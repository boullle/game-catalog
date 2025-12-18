<?php


readonly final class GamesRepository {
    public function __construct(private readonly PDO $pdo ) {

    } 
    public function findAllSortedByRating():array {
        $sql = $this->pdo->query("SELECT * FROM games ORDER BY rating DESC");
        return $sql-> fetchAll(PDO::FETCH_ASSOC);

    }
    public function findAll():array {
        $sql = $this->pdo->query("SELECT * FROM games");
        return $sql-> fetchAll(PDO::FETCH_ASSOC);
    }
    // function qui va recuperer les 3 premiers jeux

    public function findTop($limit):array {
        $sql = $this->pdo->prepare("SELECT * FROM games ORDER BY id ASC LIMIT :limit");//on ajoute du dynamisme avec le token limt
        $sql->bindValue('limit',$limit,PDO::PARAM_INT);//on lie le token :limit à l'argument $limit
        $sql->execute();// on execute
        return $sql-> fetchAll(PDO::FETCH_ASSOC);// On retourne nos valeurs
    }

    //service/games.php - fair eune nouvelle methode qui vas recuperer le 3 premier jeux 
    //puis dans la fonction appController

    public function findByID(int $id):?array{
        $sql = $this->pdo->prepare("SELECT * FROM games WHERE id=:id");//on ajoute du dynamisme avec le token limt
        $sql->bindValue('id',$id,PDO::PARAM_INT);//on lie le token :limit à l'argument $limit
        $sql->execute();// on execute
        return $sql-> fetch(PDO::FETCH_ASSOC);// On retourne nos valeurs

    }

    public function countAll():int{
        $sql = $this->pdo->query("SELECT COUNT(*) FROM games");
        return $sql->fetch(PDO::FETCH_COLUMN);
    }

}