<?php
require_once 'Datahandler.php';

class ContentsLogic{

    public function __construct()
    {
        $this->Datahandler = new Datahandler("localhost", "mysql", "mvc", "root", "");
    }

    public function __destruct()
    {
        // code
    }

    public function createContent()
    {
        if (isset($_REQUEST['submit'])) {
            $auteur = $_REQUEST['auteur'];
            $titel = $_REQUEST['titel'];
            $images = $_REQUEST['images'];
            $content = $_REQUEST['content'];
            $social = $_REQUEST['social'];
            $datum = $_REQUEST['datum'];
            $this->saveImages($images);
            if (empty($auteur) or empty($titel) or empty($images) or empty($content)or empty($social) or empty($datum)) {
                return "Alle velden zijn vereist";
            } else {
                $sql = "INSERT INTO content (auteur, titel, images, content, social, datum)
                            VALUES('$auteur', '$titel', '$images', '$content','$social','$datum')";
                $this->Datahandler->createData($sql);
                return 'Successfully created new contact!';
                    $html = "<a class=\"crudfunctionbutton\" href='index.php'><i class='fa-solid fa-circle-plus'></i> Home</a>";
                    echo $html;
            }
        }
    }

    public function readContent($id)
    {
        $sql = "SELECT id, auteur, titel, content, social, datum FROM content WHERE id=$id";
        $result = $this->Datahandler->readsData($sql);
        $res = $result->fetchAll();
        $img = $this->readImages($id);
        return [$res,$img];
    }
    public function ReadAllContent()
    {
        try {
                $sql = "SELECT id, auteur, titel, datum FROM content";
                $res = $this->Datahandler->readsData($sql);
                return $res;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateContent()
    {
        //Code
    }

    public function deleteContent($id)
    {
        $sql = "DELETE  FROM contents WHERE id=$id";
        $result = $this->Datahandler->deleteData($sql);
        return 'Succesvol verwijderd ' . $result;
    }

    public function readImages($id){
        $returnarray = [];

        $sql = "SELECT images From content Where id=".$id;
        $result = $this->Datahandler->readsData($sql);
        $content = $result->fetchAll();

        $images = explode("," , $content[0]['images']);
        foreach($images as $imageId)
        {
            $sql = "SELECT imagename FROM images WHERE id=" .$imageId;
            $result = $this->Datahandler->readsData($sql);
            $img = $result->fetchAll();

            foreach($img as $strings => $val){
                foreach($val as $image){
                    if(is_string($image)){
                        array_push($returnarray,$image);
                    }
                }
            }
        }
        return $returnarray;
    }

    public function saveImages($img){
        echo 'get fucked';
    
      
        $afbeeldingmap = "./view/assets/images";
        $afbeelding = $afbeeldingmap . basename($img);
        $uploadOk = 1;
      
     
        $check = getimagesize($img);
        if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } else {
          echo "File is not an image.";
          $uploadOk = 0;
        }
      
        if ($uploadOk == 0) {
    
          echo "Sorry, your file was not uploaded.";
    
        } else {
          if (move_uploaded_file($img, $afbeelding)) {
            echo "The file ". htmlspecialchars( basename($img)). " has been uploaded.";
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }
    
        }
    
    
}

?>