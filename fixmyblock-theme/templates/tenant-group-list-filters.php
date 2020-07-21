<?php $id = uniqid(); ?>
<div class="tenant-group-filters js-tenant-group-filters">
    <div class="form-group">
        <label for="text-<?php echo $id; ?>">Search by name, location, or type of issue</label>
        <input type="text" class="form-control js-filter-groups-by-text" id="text-<?php echo $id; ?>">
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="category-<?php echo $id; ?>">Filter by category</label>
                <select class="form-control js-filter-groups-by-category" id="category-<?php echo $id; ?>">
                    <option value="">All</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="region-<?php echo $id; ?>">Filter by location</label>
                <select class="form-control js-filter-groups-by-region" id="region-<?php echo $id; ?>">
                    <option value="">All</option>
                </select>
            </div>
        </div>
    </div>
</div>
