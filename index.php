<?php

require_once "vendor/autoload.php";

use App\Utils\App;
use App\Entity\News;
use App\Entity\Comment;
use App\Models\CommentModel;
use App\Models\NewsModel;

(new App())->boot();

$newsModel = new NewsModel;
$commentModel = new CommentModel;

function showNews() {
    global $newsModel;
    $news = $newsModel->all();
    /** @var News $data */
    foreach ($news as $data) {
        echo ("############ [ID:{$data->getId()}] NEWS " . $data->getTitle() . " ############\n");
        echo ($data->getBody() . "\n");
        if ($data->getComments()->count()) {
            /** @var Comment $comment */
            foreach ($data->getComments() as $comment) {
                echo ("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
            }
        }
    }
}

echo "--- choose transaction ---\n";
echo "1. View news\n";
echo "2. Add News\n";
echo "3. Add Comment\n";
echo "4. Delete News\n";
echo "5. Delete Comment\n";
echo "x. Exit\n";
$fin = fopen("php://stdin", "r");
$line = fgets($fin);
switch (trim($line)) {
    case '1':
        echo "You selected to View news\n";
        echo "-------------------------\n";
        showNews();
        break;

    case '2':
        echo "You selected to Add news\n";
        echo "-------------------------\n";
        echo "Title:\n";
        $fin = fopen("php://stdin", "r");
        $title = fgets($fin);
        echo "Body:\n";
        $fin = fopen("php://stdin", "r");
        $body = fgets($fin);
        $newsId = $newsModel->create(trim($title), trim($body));
        echo "\n\nSuccess! News ID: {$newsId}";

        break;

    case '3':
        echo "You selected to Add news\n";
        echo "-------------------------\n";
        echo "News ID:\n";
        $fin = fopen("php://stdin", "r");
        $newsId = fgets($fin);
        echo "Comment:\n";
        $fin = fopen("php://stdin", "r");
        $comment = fgets($fin);
        $commentId = $commentModel->create(trim($comment), trim($newsId));
        echo "\n\nSuccess! Comment ID: {$commentId}";

        break;

    case '4':
        echo "You selected to Delete news\n";
        echo "-------------------------\n";
        echo "News ID:\n";
        $fin = fopen("php://stdin", "r");
        $newsId = fgets($fin);
        $newsModel->delete(trim($newsId));
        echo "\n\nSuccess! News ID: {$newsId} has been deleted";

        break;

    case '5':
        echo "You selected to Delete comment\n";
        echo "-------------------------\n";
        echo "Comment ID:\n";
        $fin = fopen("php://stdin", "r");
        $commentId = fgets($fin);
        $commentModel->delete(trim($commentId));
        echo "\n\nSuccess! Comment ID: {$commentId} has been deleted";

        break;

    case 'x':
        echo "Bye!\n";

        break;
    
    default:
        echo "Selected option not available!";
        break;
}
