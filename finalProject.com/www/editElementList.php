<link rel="stylesheet" href="./style/editElementListStyle.css">

<?php
    require "header.php";
?>

<section class="editElementList__section">
        <div class="container">
            <div class="container__editElements">

            <?php
                        $result = mysqli_query($connection, "SELECT * FROM products");		
                        $image_link = mysqli_query($connection, "SELECT * FROM images");
                        $rows = mysqli_num_rows($result);
                        $rows_photo = mysqli_num_rows($image_link);
                        for ($i = 0; $i < $rows; $i++) {
                            $row = mysqli_fetch_row($result);
                            $image_link = mysqli_query($connection, "SELECT * FROM images WHERE product_id=" . $row[0]);
                            for ($j = 0; $j < $rows_photo; $j++) {
                                $row_photo = mysqli_fetch_row($image_link);
                                if ($row_photo[1] == $row[0]){
                                    $photo[$i] = $row_photo[2];
                                    break;
                                }

                            }}

                        $result = mysqli_query($connection, "SELECT * FROM `products`");
                        
                        $i = 0;

                        while ($res = mysqli_fetch_assoc($result)){
            ?>

                <div class="editElement">

                    <div class="img__editElement">
                        <img
                            src="<?php echo $photo[$i]; ?>">
                    </div>

                    <div class="info__element">
                        <p class="name__editElement">Name: <span><?php echo $res['name'];?></span></p>
                        <p class="price__editElement">Price: $<span><?php echo $res['price'];?></span></p>
                        
                        <form action="deletePage.php" name="deleteItem" method="GET">
                            <input type="submit" class="btn__editElement" value="DELETE">
                            <input type="hidden" value="<?php echo $res['id'];?>" name="id">
                        </form>
                    </div>

                </div>

                <?php
                        $i++;
                        }
                ?> 

            </div>
        </div>
    </section>