<?php

define('ROOT_DIR', str_replace(DIRECTORY_SEPARATOR, '/', getcwd()));

include __DIR__ . '/config/config.php';
include __DIR__ . '/libs/Text.php';

$page_total = 0;
$page = 0;
$index = 0;
$chapter_counter = 0;
$verse_counter = 0;

$folder = ROOT_DIR . '/flextype';

mkdir($folder);

echo "\n\n";

foreach ($locales as $locale) {

    $page = 0;
    $index = 0;
    $chapter_counter = 0;
    $verse_counter = 0;

    $filecontent = file_get_contents($biblePath . "/{$locale}/bible.json");
    $books = json_decode($filecontent);

    echo "Locale: " . $locale . "\n";

    mkdir($folder . '/' . Text::safeString($locale));
    $data = "---\ntitle: {$locale}\ntemplate: locale\n---\n";
    file_put_contents($folder . '/' . Text::safeString($locale) . '/entry.md', $data);

    foreach ($books->Book as $book) {

        $page++;
        $page_total++;

        $chapter_counter = 0;

        $current_index = $index;

        echo "Book: " . $book_names[$current_index] . "\n";

        mkdir($folder . '/' . Text::safeString($locale) . '/'.  Text::safeString($book_names[$current_index]));
        $data = "---\ntitle: ". $book_names[$current_index] ."\ntemplate: book\n---\n";
        file_put_contents($folder . '/' .Text::safeString($locale) .'/'.  Text::safeString($book_names[$current_index]) . '/entry.md', $data);

        $index++;

        foreach ($book->Chapter as $chapter) {

            $page++;
            $page_total++;

            $verse_counter = 0;

            $chapter_counter++;

            mkdir($folder . '/' . Text::safeString($locale) . '/' . Text::safeString($book_names[$current_index]) . '/' .  $chapter_counter);
            $data = "---\ntitle: Chapter {$chapter_counter}\ntemplate: chapter\n---\n";
            file_put_contents($folder . '/' . Text::safeString($locale) . '/' . Text::safeString($book_names[$current_index]) . '/'.  $chapter_counter . '/entry.md', $data);



            foreach ($chapter->Verse as $verse) {

                $page++;
                $page_total++;

                $verse_counter++;

                mkdir($folder . '/' . Text::safeString($locale).'/'.Text::safeString($book_names[$current_index]).'/'.  $chapter_counter  .'/' . $verse_counter);

                $data = "---\ntitle: Verse {$verse_counter}\ntemplate: verse\n---\n{$verse->Verse}";
                file_put_contents($folder . '/' .Text::safeString($locale).'/'.Text::safeString($book_names[$current_index]).'/'.  $chapter_counter  .'/' . $verse_counter . '/entry.md', $data);

            }

        }
    }
echo "\n\n======================== \n\nPages: ". $page . "\n\n========================\n\n";

}

echo "\n\n======================== \n\nPages Total: ". $page_total . "\n\n========================\n\n";

echo "\n\n";
