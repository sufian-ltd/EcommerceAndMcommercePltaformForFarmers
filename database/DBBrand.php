<?php
require_once "DB.php";
class DBBrand
{
    private $table = "category";
    public function addBrand($name, $status, $totalProduct)
    {
        $sql="INSERT into $this->table(name,status,totalProduct) values (:name,:status,:totalProduct)";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':status',$status);
        $stmt->bindParam(':totalProduct',$totalProduct);
        return $stmt->execute();
    }
    public function getBrand()
    {
        $sql="SELECT * FROM $this->table";
        $stmt=DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getBrandById($id)
    {
        $sql="SELECT * FROM $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function updateBrand($id,$name, $status)
    {
        $sql="UPDATE $this->table set name=:name,status=:status where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':status',$status);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
    public function deleteBrand($id)
    {
        $sql="DELETE from $this->table where id=:id";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }
    public function searchBrand($key)
    {
        $sql="SELECT * FROM $this->table where name like :name";
        $stmt=DB::prepare($sql);
        $key='%'.$key.'%';
        $stmt->bindParam(':name',$key);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function addQtnToCategory($category,$qtn)
    {
        $sql="UPDATE $this->table set totalProduct=totalProduct+$qtn where name=:name";
        $stmt=DB::prepare($sql);
        $stmt->bindParam(':name',$category);
        return $stmt->execute();
    }
}