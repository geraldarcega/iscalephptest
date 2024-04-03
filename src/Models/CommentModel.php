<?php

namespace App\Models;

use App\Model;
use Carbon\Carbon;
use App\Entity\Comment;

class CommentModel extends Model
{
    protected string $entity = Comment::class;

    public function all(): array
    {
        $query = $this->db
            ->entityManager()
            ->createQueryBuilder()
            ->select('c', 'n')
            ->from($this->entity, 'c')
            ->join('n.news', 'n')
            ->getQuery();

        return $query->getResult();
    }

    public function create($body, $newsId)
    {
        $news = (new NewsModel)->find($newsId);
        if (is_null($news)) {
            throw new \Exception('News ID: '. $newsId . ' does not exists');
        }
        $comment = (new Comment)
            ->setBody($body)
            ->setNews($news)
            ->setCreatedAt(Carbon::now());
        $this->db->entityManager()->persist($comment);
        $this->db->entityManager()->flush();

        return $comment->getId();
    }

    public function delete($id): bool
    {
        $comment = $this->find($id);
        if (is_null($comment)) {
            throw new \Exception('Comment ID: ' . $id . ' does not exists');
        }

        $this->db->entityManager()->remove($comment);
        $this->db->entityManager()->flush();

        return true;
    }
}