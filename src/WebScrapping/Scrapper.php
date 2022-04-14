<?php

namespace Galoa\ExerciciosPhp2022\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper
{

  /**
   * Loads paper information from the HTML and creates a XLSX file.
   */
  public function scrap(\DOMDocument $dom): void
  {
    $node_list = $dom->getElementsByTagName('body')[0];
    $node_list = $node_list->childNodes[3]->childNodes[11];

    $articles = [];
    foreach ($node_list->childNodes as $n) {
      if ($n->nodeName == "a") {
        $value = [];
        $authors = [];
        $value += ["ID" => $n->childNodes[2]->childNodes[1]->childNodes[1]->nodeValue];
        $value += ["Title" => $n->childNodes[0]->nodeValue];
        $value += ["Type" => $n->childNodes[2]->childNodes[0]->nodeValue];

        $i = 0;
        foreach ($n->childNodes[1]->childNodes as $a) {
          if ($a->nodeName == "span") {
            $authors += ["author-" . $i => [$a->nodeValue, $a->attributes[0]->nodeValue]];
          }
          $i++;
        }

        $value += ["Authors" => $authors];
        $articles += [$n->childNodes[2]->childNodes[1]->childNodes[1]->nodeValue => $value];
      }
    }
    // $articles;


    $filePath = __DIR__ . '/../../webscrapping/model.xlsx';

    $writer = WriterEntityFactory::createXLSXWriter();
    // $writer = WriterEntityFactory::createODSWriter();
    // $writer = WriterEntityFactory::createCSVWriter();

    $writer->openToFile($filePath); // write data to a file or to a PHP stream
    //$writer->openToBrowser($fileName); // stream data directly to the browser

    $cellsTitle = [
      WriterEntityFactory::createCell('ID'),
      WriterEntityFactory::createCell('Title'),
      WriterEntityFactory::createCell('Type'),
      WriterEntityFactory::createCell('Author 1'),
      WriterEntityFactory::createCell('Author 1 Institution'),
      WriterEntityFactory::createCell('Author 2'),
      WriterEntityFactory::createCell('Author 2 Institution'),
      WriterEntityFactory::createCell('Author 3'),
      WriterEntityFactory::createCell('Author 3 Institution'),
      WriterEntityFactory::createCell('Author 4'),
      WriterEntityFactory::createCell('Author 4 Institution'),
      WriterEntityFactory::createCell('Author 5'),
      WriterEntityFactory::createCell('Author 5 Institution'),
      WriterEntityFactory::createCell('Author 6'),
      WriterEntityFactory::createCell('Author 6 Institution'),
      WriterEntityFactory::createCell('Author 7'),
      WriterEntityFactory::createCell('Author 7 Institution'),
      WriterEntityFactory::createCell('Author 8'),
      WriterEntityFactory::createCell('Author 8 Institution'),
      WriterEntityFactory::createCell('Author 9'),
      WriterEntityFactory::createCell('Author 9 Institution')
    ];

    $titleRow = WriterEntityFactory::createRow($cellsTitle);
    $writer->addRow($titleRow);


    foreach ($articles as $a) {
      $cells = [];
      array_push($cells, WriterEntityFactory::createCell($a['ID']));
      array_push($cells, WriterEntityFactory::createCell($a['Title']));
      array_push($cells, WriterEntityFactory::createCell($a['Type']));
      foreach ($a["Authors"] as $b) {
        array_push($cells, WriterEntityFactory::createCell($b[0]));
        array_push($cells, WriterEntityFactory::createCell($b[1]));
      }
      $titleRow = WriterEntityFactory::createRow($cells);
      $writer->addRow($titleRow);
    }


    $writer->close();
  }
}
