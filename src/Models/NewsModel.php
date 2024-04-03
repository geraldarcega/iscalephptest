<?php

namespace App\Models;

use App\Entity\News;
use App\Model;
use Carbon\Carbon;
use Doctrine\Common\Collections\Collection;
use Exception;

class NewsModel extends Model
{
    protected string $entity = News::class;

    public function all(): array
    {
        $query = $this->db
            ->entityManager()
            ->createQueryBuilder()
            ->select('n', 'c')
            ->from($this->entity, 'n')
            ->leftJoin('n.comments', 'c')
            ->getQuery();

        return $query->getResult();
    }

    public function create(string $title, string $body)
    {
        $news = (new News())
            ->setTitle($title)
            ->setBody($body)
            ->setCreatedAt(Carbon::now());
        $this->db->entityManager()->persist($news);
        $this->db->entityManager()->flush();

        return $news->getId();
    }

    public function delete(int $id): bool
    {
        $news = $this->find($id);
        if (is_null($news)) {
            throw new \Exception('News ID: ' . $id . ' does not exists');
        }

        $this->db->entityManager()->remove($news);
        $this->db->entityManager()->flush();

        return true;
    }
}
