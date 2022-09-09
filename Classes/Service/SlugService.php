<?php

declare(strict_types=1);

namespace In2code\GbEvents\Service;

use In2code\GbEvents\Utility\DatabaseUtility;
use PDO;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SlugService
{
    /**
     * @var SlugHelper
     */
    protected $slugHelper;

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var array
     */
    protected $fieldConfig = [];

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var string
     */
    protected $slugField = '';

    /**
     * @var string
     */
    protected $targetField = '';

    public function __construct(string $table, string $targetField, string $slugField)
    {
        $this->table = $table;
        $this->slugField = $slugField;
        $this->targetField = $targetField;

        /** @var QueryBuilder $queryBuilder */
        $this->queryBuilder =
            GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);

        $fieldConfig = $GLOBALS['TCA'][$table]['columns'][$slugField]['config'];
        $this->slugHelper =
            GeneralUtility::makeInstance(SlugHelper::class, $table, $slugField, $fieldConfig);
    }

    /**
     * @return array
     */
    public function performUpdates(): array
    {
        $this->queryBuilder->getRestrictions()->removeAll();
        $databaseQueries = [];

        $statement = $this->queryBuilder->select('*')
            ->from($this->table)
            ->where(
                $this->queryBuilder->expr()->orX(
                    $this->queryBuilder->expr()->eq(
                        $this->slugField,
                        $this->queryBuilder->createNamedParameter('', PDO::PARAM_STR)
                    ),
                    $this->queryBuilder->expr()->isNull($this->slugField)
                )
            )
            ->execute();
        while ($record = $statement->fetch()) {
            if ((string)$record[$this->targetField] !== '') {
                $slug = $this->slugHelper->generate($record, (int)$record['pid']);

                if ($this->isSlugAlreadyTaken($slug)) {
                    $slug = $slug . '-' . $record['uid'];
                }

                $this->queryBuilder->update($this->table)
                    ->where(
                        $this->queryBuilder->expr()->eq(
                            'uid',
                            $this->queryBuilder->createNamedParameter($record['uid'], PDO::PARAM_INT)
                        )
                    )
                    ->set($this->slugField, $slug);
                $databaseQueries[] = $this->queryBuilder->getSQL();
                $this->queryBuilder->execute();
            }
        }

        return $databaseQueries;
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function isSlugAlreadyTaken(string $slug): bool
    {
        $queryBuilder = DatabaseUtility::getQueryBuilderForTable($this->table);
        $queryBuilder->getRestrictions()->removeAll();
        $count = $queryBuilder->count('uid')
            ->from($this->table)
            ->where(
                $queryBuilder->expr()->eq(
                    $this->slugField,
                    $queryBuilder->createNamedParameter($slug, PDO::PARAM_STR)
                )
            )
            ->execute()->fetchColumn(0);

        if ($count > 0) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isSlugUpdateRequired(): bool
    {
        $this->queryBuilder->getRestrictions()->removeAll();

        $count = $this->queryBuilder->count('uid')
            ->from($this->table)
            ->where(
                $this->queryBuilder->expr()->orX(
                    $this->queryBuilder->expr()->eq(
                        $this->slugField,
                        $this->queryBuilder->createNamedParameter('', PDO::PARAM_STR)
                    ),
                    $this->queryBuilder->expr()->isNull($this->slugField)
                )
            )
            ->execute()->fetchColumn(0);

        if ($count > 0) {
            return true;
        }

        return false;
    }
}
