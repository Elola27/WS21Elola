<?php
function eremuakKonprobatu($datuak)
{
    if (!preg_match("/^(([a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(eus|es))|([a-zA-Z]+\.[a-zA-Z]+@ehu\.(eus|es)|[a-zA-Z]+@ehu\.(eus|es)))$/i", $datuak["eposta"]))
    {
        return 'Eposta okerra';
    }
    else if (strlen($datuak["galdera"]) < 10 || !ezHutsaVal($datuak["galdera"]))
    {
        return 'Galdera testua oso motza';
    }
    else if (!ezHutsaVal($datuak["erzuzen"]))
    {
        return 'Erantzun zuzena hutsa da';
    }
    else if (!ezHutsaVal($datuak["eroker1"]))
    {
        return '1. erantzun okerra hutsa da';
    }
    else if (!ezHutsaVal($datuak["eroker2"]))
    {
        return '2. erantzun okerra hutsa da';
    }
    else if (!ezHutsaVal($datuak["eroker3"]))
    {
        return '3. erantzun okerra hutsa da';
    }
    else if (!(1 <= $datuak["zail"] && $datuak["zail"] <= 3))
    {
        return 'Zailtasuna okerra da';
    }
    else if (!ezHutsaVal($datuak["arlo"]))
    {
        return 'Gaia okerra da';
    }
    return '';
}

function ezHutsaVal($text)
{
    return preg_match("/^((\S)+( )*)+$/", $text);
}

function galderaGehitu()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') $aldagaiak = $_GET;
    else if ($_SERVER['REQUEST_METHOD'] == 'POST') $aldagaiak = $_POST;
    else die("Konexioa egitean datuak ezin izan dira lortu");

    if (($konprobazioa = eremuakKonprobatu($aldagaiak)) != '')
    {
        return "<b style='color: red'>Galdera ez da ondo bete: " . $konprobazioa . "</b>
                            <button onclick='window.history.back()'>Berriro saiatu</button>";
    }

    $emaitza = '';
    // DB-n gorde
    $emaitza .= db_gorde($aldagaiak);

    // XML-n gorde
    $emaitza .= xml_gorde($aldagaiak);

    // JSON-en gorde
    $emaitza .= json_gorde($aldagaiak);

    if ($emaitza != '')
    {
        return $emaitza . "<button onclick='window.history.back()'>Berriro saiatu</button>";
    }

    //Eposta URL-an badago orduan eposta defektuz hau izango da
    /*$parametroak = "";
                if (isset($_GET['eposta'])) {
                    $parametroak = "?eposta=".$_GET['eposta'];
                    $parametroak = $parametroak."&irudia=".$_GET['irudia'];
                }*/
    return "<p>Galdera ondo gorde da DB-n, XML-n eta JSON-en</p>";

}

function db_gorde(array $aldagaiak)
{
    include 'DbConfig.php';
    //global $zerbitzaria, $erabiltzailea, $gakoa, $db;
    $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

    if ($nireSQLI->connect_error)
    {
        return "<b style='color: red'>DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error . "</b><br/>";
    }

    $irudia = "";
    /*if ($_FILES["irudia"]["tmp_name"] != "")
    {
        $irudiaIzen = $_FILES["irudia"]["tmp_name"];
        $irudia = addslashes(file_get_contents($irudiaIzen));
    }*/

    $sqlInsertQuestion = "INSERT INTO dbt51_questions(Eposta, Galdera, erZuzena, erOkerra1, erOkerra2, erOkerra3, Zailtasuna, Arloa, Argazkia) 
                VALUES ('$aldagaiak[eposta]', '$aldagaiak[galdera]', '$aldagaiak[erzuzen]', '$aldagaiak[eroker1]', '$aldagaiak[eroker2]', 
                        '$aldagaiak[eroker3]', '$aldagaiak[zail]', '$aldagaiak[arlo]', '$irudia')";

    if (!$nireSQLI->query($sqlInsertQuestion))
    {
        return '<b style="color: red">Errorea: ' . $nireSQLI->error . "</b><br/>";
    }

    return "";
}

function xml_gorde(array $aldagaiak)
{
    $fitxategia = "../xml/Questions.xml";
    $xml = simplexml_load_file($fitxategia);

    // Konprobatu fitxategia ondo kargatu dela
    if (!$xml) return "<b style='color: red'>Ez da Questions.xml fitxategia aurkitu, ezin izan da XML bezala gorde.</b><br/>";

    // Galdetegia bete
    $galdetegiaItem = $xml->addChild('assessmentItem');
    $galdetegiaItem->addAttribute('author', $aldagaiak["eposta"]);
    $galdetegiaItem->addAttribute('subject', $aldagaiak["arlo"]);
    $galdetegiaItem->addChild('itemBody')
        ->addChild('p', $aldagaiak["galdera"]);
    $galdetegiaItem->addChild('correctResponse')
        ->addChild('response', $aldagaiak["erzuzen"]);
    $erantzunOkerrak = $galdetegiaItem->addChild('incorrectResponses');
    $erantzunOkerrak->addChild('response', $aldagaiak["eroker1"]);
    $erantzunOkerrak->addChild('response', $aldagaiak["eroker2"]);
    $erantzunOkerrak->addChild('response', $aldagaiak["eroker3"]);

    $domxml = new DOMDocument('1.0');
    $domxml->preserveWhiteSpace = false;
    $domxml->formatOutput = true;
    $domxml->loadXML($xml->asXML());
    $gordeketa = $domxml->save($fitxategia);
    if (!$gordeketa) return "<b style='color: red'>Ezin izan da XML fitxategia gorde.</b><br/>";
    return "";
}

function json_gorde(array $aldagaiak)
{
    $fitxategia = "../json/Questions.json";
    $json_raw = file_get_contents($fitxategia);
    if (!$json_raw) return "<b style='color: red'>Ez da Questions.json fitxategia aurkitu, ezin izan da JSON bezala gorde.</b><br/>";
    $json = json_decode($json_raw);

    $galdetegia = new stdClass();
    $galdetegia->subject = $aldagaiak["arlo"];
    $galdetegia->author = $aldagaiak["eposta"];
    $galdetegia->itemBody = new stdClass();
    $galdetegia
        ->itemBody->p = $aldagaiak["galdera"];
    $galdetegia->correctResponse = new stdClass();
    $galdetegia
        ->correctResponse->response = $aldagaiak["erzuzen"];
    $erantzunoker = array(
        $aldagaiak["eroker1"],
        $aldagaiak["eroker2"],
        $aldagaiak["eroker3"]
    );
    $galdetegia->incorrectResponses = new stdClass();
    $galdetegia
        ->incorrectResponses->response = $erantzunoker;

    array_push($json->assessmentItems, $galdetegia);
    $jsonBerria = json_encode($json, JSON_PRETTY_PRINT);

    $gordeketa = file_put_contents($fitxategia, $jsonBerria);
    if (!$gordeketa || $gordeketa === 0) return "<b style='color: red'>Ezin izan da JSON fitxategia gorde.</b><br/>";
}

echo "<p>" . galderaGehitu() . "</p>"
?>
