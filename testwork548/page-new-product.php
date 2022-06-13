<?php
/*
Template Name: Добавить новый продукт
*/
?>

<?php
get_header();
?>

<section>
    <div class="container">
        <div class="new-product-page-wrapper">
            <h1 class="section-title">Добавить новый продукт</h1>

            <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
                <div class="new-product-form">
                    <input type="text" id="new-product-name" name="new-product-name" placeholder="Название продукта" required>
                    <input type="number" id="new-product-price" name="new-product-price" placeholder="Цена продукта" required>
                    <input type="text" id="new-product-date" name="new-product-date" placeholder="Дата создания продукта" required>
                    <select id="new-product-select" name="new-product-select">
                        <option disabled value="default">Выберите тип продукта</option>
                        <option value="rare">rare</option>
                        <option value="frequent">frequent</option>
                        <option value="unusual">unusual</option>
                    </select>
                </div>
                <div class="new-product-img"><input type="file" name="new-product-img[]" accept="image/*"></div>
                <div class="new-product-submit"><input type="submit"></div>
            </form>

        </div>
    </div>
</section>

<?php
get_footer();
?>