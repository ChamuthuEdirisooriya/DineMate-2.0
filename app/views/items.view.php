<?php include "partials/dashboard.header.php" ?>
    <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
        <h1 class="display-3">Items</h1>
        <a class="btn btn-primary text-uppercase fw-bold" href="items/create">+ Create Item</a>
    </div>
    <div>
        <form action="" method="GET">
            <div class="row">
                <div class="form-search col-10">
                    <input type="text" class="form-control" name="query" placeholder="Search items">
                    <button class="form-search-icon" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
                <div class="pl-2 col-2">
                    <select class="form-control" name="category">
                        <option value="">Filter Category</option>
                        <option>Beverages</option>
                        <option>Bread</option>
                        <option>Canned Goods</option>
                        <option>Dairy</option>
                        <option>Frozen Foods</option>
                        <option>Meat</option>
                        <option>Produce</option>
                        <option>Snacks</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Brand</th>
            <th>Description</th>
            <th>Measure</th>
            <th>Category</th>
        </tr>
        </thead>
        <?php if (isset($items) && !empty($items)) : ?>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <?php foreach ($item as $col): ?>
                        <th><?= $col ?></th>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <th colspan="6" class="text-center">No Records Found</th>
        <?php endif ?>
    </table>
<?php include "partials/dashboard.footer.php" ?>