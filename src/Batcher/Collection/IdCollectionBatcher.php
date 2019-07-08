<?php

declare(strict_types=1);

namespace Setono\DoctrineORMBatcher\Batcher\Collection;

use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\DoctrineORMBatcher\Batch\CollectionBatch;

final class IdCollectionBatcher extends CollectionBatcher
{
    /**
     * @return iterable|CollectionBatch[]
     *
     * @throws StringsException
     */
    public function getBatches(int $batchSize = 100): iterable
    {
        $result = $this->getResult(sprintf('%s.%s', $this->alias, $this->identifier), $batchSize);

        foreach ($result as $ids) {
            $flattened = array_map(function ($elm) {
                return $elm[$this->identifier];
            }, $ids);

            yield new CollectionBatch($flattened, $this->getBatchableQueryBuilder());
        }
    }
}
