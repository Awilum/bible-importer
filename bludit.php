<?php

define('ROOT_DIR', str_replace(DIRECTORY_SEPARATOR, '/', getcwd()));

include __DIR__ . '/config/config.php';
include __DIR__ . '/libs/Text.php';

$page_total = 0;
$page = 0;
$index = 0;
$chapter_counter = 0;
$verse_counter = 0;
$data = "<?php defined('BLUDIT') or die('Bludit CMS.'); ?>\n{";

$bluditFolder = ROOT_DIR . '/bludit';
$databaseFolder = ROOT_DIR . '/bludit/databases';
$pagesFolder = ROOT_DIR . '/bludit/pages';

mkdir($bluditFolder);
mkdir($databaseFolder);
mkdir($pagesFolder);

echo "\n\n";

foreach ($locales as $locale) {

    $page = 0;
    $index = 0;
    $chapter_counter = 0;
    $verse_counter = 0;

    $filecontent = file_get_contents($biblePath . "/{$locale}/bible.json");
    $books = json_decode($filecontent);

    echo "Locale: " . $locale . "\n";

    mkdir($pagesFolder . '/' . Text::safeString($locale));
    $data .= '"'.Text::safeString($locale).'":{"title":"'.$locale.'", "description":"", "username":"admin", "tags":[ ], "type":"published", "date":"2021-04-17 19:27:20", "dateModified":"", "position":1, "coverImage":"", "category":"", "md5file":"4112131488553e686103d300d385467f", "uuid":"1f2bcda98f5d62d1ad1b57487f5fb258", "allowComments":true, "template":"", "noindex":false, "nofollow":false, "noarchive":false, "custom":[ false ]},';
    file_put_contents($pagesFolder . '/' . Text::safeString($locale) . '/index.txt', '');

    foreach ($books->Book as $book) {

        $page++;
        $page_total++;

        $chapter_counter = 0;

        $current_index = $index;

        echo "Book: " . $book_names[$current_index] . "\n";

        mkdir($pagesFolder . '/' . Text::safeString($locale) . '/'.  Text::safeString($book_names[$current_index]));
        $data .= '"'.Text::safeString($locale) . '\/' . Text::safeString($book_names[$current_index]) .'":{"title":"Book: ' . $book_names[$current_index] . '", "description":"", "username":"admin", "tags":[ ], "type":"published", "date":"2021-04-17 19:27:20", "dateModified":"", "position":1, "coverImage":"", "category":"", "md5file":"4112131488553e686103d300d385467f", "uuid":"1f2bcda98f5d62d1ad1b57487f5fb258", "allowComments":true, "template":"", "noindex":false, "nofollow":false, "noarchive":false, "custom":[ false ]},';
        file_put_contents($pagesFolder . '/' .Text::safeString($locale) . '/'.  Text::safeString($book_names[$current_index]) . '/index.txt', '');

        $index++;

        foreach ($book->Chapter as $chapter) {

            $page++;
            $page_total++;

            $verse_counter = 0;

            $chapter_counter++;

            mkdir($pagesFolder . '/' . Text::safeString($locale) . '/' . Text::safeString($book_names[$current_index]) . '/' .  $chapter_counter);
            $data .= '"'.Text::safeString($locale) . '\/' . Text::safeString($book_names[$current_index]) . '\/' . $chapter_counter .'":{"title":"Chapter: ' . $chapter_counter . '", "description":"", "username":"admin", "tags":[ ], "type":"published", "date":"2021-04-17 19:27:20", "dateModified":"", "position":1, "coverImage":"", "category":"", "md5file":"4112131488553e686103d300d385467f", "uuid":"1f2bcda98f5d62d1ad1b57487f5fb258", "allowComments":true, "template":"", "noindex":false, "nofollow":false, "noarchive":false, "custom":[ false ]},';
            file_put_contents($pagesFolder . '/' . Text::safeString($locale) . '/' . Text::safeString($book_names[$current_index]) . '/'.  $chapter_counter . '/index.txt', '');

            foreach ($chapter->Verse as $verse) {

                $page++;
                $page_total++;

                $verse_counter++;

                mkdir($pagesFolder . '/' . Text::safeString($locale).'/'.Text::safeString($book_names[$current_index]).'/'.  $chapter_counter  .'/' . $verse_counter);
                $data .= '"'.Text::safeString($locale) . '\/' . Text::safeString($book_names[$current_index]) . '\/' . $chapter_counter . '\/' . $verse_counter .'":{"title":"Verse: ' . $verse_counter . '", "description":"", "username":"admin", "tags":[ ], "type":"published", "date":"2021-04-17 19:27:20", "dateModified":"", "position":1, "coverImage":"", "category":"", "md5file":"4112131488553e686103d300d385467f", "uuid":"1f2bcda98f5d62d1ad1b57487f5fb258", "allowComments":true, "template":"", "noindex":false, "nofollow":false, "noarchive":false, "custom":[ false ]},';
                file_put_contents($pagesFolder . '/' .Text::safeString($locale).'/'.Text::safeString($book_names[$current_index]).'/'.  $chapter_counter  .'/' . $verse_counter . '/index.txt', $verse->Verse);
            }

        }
    }
echo "\n\n======================== \n\nPages: ". $page . "\n\n========================\n\n";

}

$data = substr($data, 0, -1);

$data .= '}';

file_put_contents($databaseFolder . '/pages.php', $data);

echo "\n\n======================== \n\nPages Total: ". $page_total . "\n\n========================\n\n";

echo "\n\n";
