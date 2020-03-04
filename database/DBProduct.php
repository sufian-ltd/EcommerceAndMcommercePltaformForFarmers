<?php
    require_once "DB.php";
    class DBProduct
    {
        private $table = "product";

        public function addProduct($category,$name,$unit,$beforeDiscount, $afterDiscount,$qtn,$image,$sells)
        {
            $sql="INSERT into $this->table(category,name,unit,beforeDiscount,afterDiscount,qtn,image,sells)
            values (:category,:name,:unit,:beforeDiscount,:afterDiscount,:qtn,:image,:sells)";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':category',$category);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':unit',$unit);
            $stmt->bindParam(':beforeDiscount',$beforeDiscount);
            $stmt->bindParam(':afterDiscount',$afterDiscount);
            $stmt->bindParam(':qtn',$qtn);
            $stmt->bindParam(':image',$image);
            $stmt->bindParam(':sells',$sells);
            return $stmt->execute();
        }
        public function getCategories()
        {
            $sql="SELECT name FROM category";
            $stmt=DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getProduct()
        {
            $sql="SELECT * FROM $this->table";
            $stmt=DB::prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getProductById($id)
        {
            $sql="SELECT * FROM $this->table where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            return $stmt->fetch();
        }
        public function updateProduct($id,$name,$unit,$beforeDiscount, $afterDiscount,$qtn,$image,$sells)
        {
            $sql="UPDATE $this->table set name=:name,unit=:unit,beforeDiscount=:beforeDiscount,
            afterDiscount=:afterDiscount,qtn=:qtn,image=:image,sells=:sells where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':unit',$unit);
            $stmt->bindParam(':beforeDiscount',$beforeDiscount);
            $stmt->bindParam(':afterDiscount',$afterDiscount);
            $stmt->bindParam(':qtn',$qtn);
            $stmt->bindParam(':image',$image);
            $stmt->bindParam(':sells',$sells);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }
        public function deleteProduct($id)
        {
            $sql="DELETE from $this->table where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }
        public function getProductsByCatAndSubCat($category,$subCategory)
        {
            $sql="select * from $this->table where category=:category and subCategory=:subCategory";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':category',$category);
            $stmt->bindParam(':subCategory',$subCategory);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getProductByCategory($category)
        {
            $sql="SELECT * FROM $this->table where category=:category";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':category',$category);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function getProductBySubCategory($subCategory)
        {
            $sql="SELECT * FROM $this->table where subCategory=:subCategory";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':subCategory',$subCategory);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function searchProduct($key)
        {
            $sql="SELECT * FROM $this->table where category like :category or name like :name";
//            $sql="SELECT * FROM $this->table where category like ? or subCategory like ? or productName like ?";
            $stmt=DB::prepare($sql);
            $key='%'.$key.'%';
            $stmt->bindParam(':category',$key);
            $stmt->bindParam(':name',$key);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        public function sellProduct($productId)
        {
            $sql="UPDATE $this->table set sells=sells+1 where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$productId);
            return $stmt->execute();
        }
        public function updateStock($productId,$qtn)
        {
            $sql="UPDATE $this->table set qtn=qtn-$qtn where id=:id";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':id',$productId);
            return $stmt->execute();
        }
        public function getTotalProductByCategory($category)
        {
            $sql="SELECT count(id) as id FROM $this->table where category=:category";
            $stmt=DB::prepare($sql);
            $stmt->bindParam(':category',$category);
            $stmt->execute();
            return $stmt->fetch();
        }
    }
?>