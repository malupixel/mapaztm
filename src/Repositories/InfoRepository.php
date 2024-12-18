<?php
declare(strict_types=1);

namespace App\Repositories;

use DateTimeImmutable;

final class InfoRepository extends BaseRepository
{
    public function getLastApiRead(): \DateTimeImmutable
    {
        $result = $this->db->query('SELECT * FROM info WHERE "key" = \'last-api-read\' LIMIT 1');

        if (count($result) === 0) {
            return DateTimeImmutable::createFromFormat("Y-m-d H:i:s", "2000-01-01 00:00:00");
        }

        return DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $result[0]['created_at']);
    }

    public function logLastApiRead(): void
    {

        $this->db->query(
            sprintf(
                'UPDATE info SET created_at = \'%s\' WHERE "key" = \'last-api-read\'',
                (new DateTimeImmutable())->format('Y-m-d H:i:s')
            )
        );
    }

    public function isLastApiReadOld(): bool
    {
        $maxTime = (new \DateTimeImmutable())->sub(new \DateInterval('PT13S'));

        return $this->getLastApiRead() <= $maxTime;

    }
}