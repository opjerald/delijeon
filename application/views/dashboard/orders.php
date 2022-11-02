<main class="dashboard">
    <form id="filters_form" class="controls">
        <div class="form__group input">
            <input type="text" class="form__field search_field" placeholder="something" id='search' name="search" />
            <label for="search" class="form__label">Search</label>
        </div>
        <select class="filter_status" name="status">
            <option value="">All</option>
            <option value="Order in Process">Order in Process</option>
            <option value="Shipped">Shipped</option>
            <option value="Cancelled">Cancelled</option>
        </select>
    </form>
    <table class="orders">
    </table>
</main>