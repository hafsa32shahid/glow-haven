<!-- Sidebar -->
<div class="col-lg-3 col-md-4">
  <div class="p-3 border bg-light">
    <h5 class="mb-4">Filter Products</h5>
    <form method="POST" action="filtered-products.php">
      <!-- Categories Filter -->
<div class="mb-4">
  <h6 class="fw-bold">Categories</h6>
  <div class="d-flex">
    <ul class="list-unstyled">
      <li><input type="checkbox" class="form-check-input me-2" id="category1" name="categories[]" value="Necklace"> <label for="category1">Necklaces</label></li>
      <li><input type="checkbox" class="form-check-input me-2" id="category2" name="categories[]" value="Earrings"> <label for="category2">Earrings</label></li>
      <li><input type="checkbox" class="form-check-input me-2" id="category3" name="categories[]" value="Rings"> <label for="category3">Rings</label></li>
      <li><input type="checkbox" class="form-check-input me-2" id="category4" name="categories[]" value="Bracelete"> <label for="category4">Bracelets</label></li>
    </ul>
    <ul class="list-unstyled ms-1">
      <li><input type="checkbox" class="form-check-input ms-1" id="cosmetics1" name="categories[]" value="Lipsticks"> <label for="cosmetics1">Lipsticks</label></li>
      <li><input type="checkbox" class="form-check-input ms-1" id="cosmetics2" name="categories[]" value="Foundation"> <label for="cosmetics2">Foundations</label></li>
      <li><input type="checkbox" class="form-check-input ms-1" id="cosmetics3" name="categories[]" value="Eyeliner"> <label for="cosmetics3">Eyeliners</label></li>
      <li><input type="checkbox" class="form-check-input ms-1" id="cosmetics4" name="categories[]" value="Blush"> <label for="cosmetics4">Blushes</label></li>
      <li><input type="checkbox" class="form-check-input ms-1" id="cosmetics5" name="categories[]" value="Eyeshadow"> <label for="cosmetics5">Eyeshadow</label></li>
    </ul>
  </div>
</div>

      <!-- Price Range Filter -->
      <div class="mb-4">
        <h6 class="fw-bold">Price Range</h6>
        <input type="range" class="form-range" min="0" max="10000" step="100" id="priceRange" name="priceRange">
        <div class="d-flex justify-content-between">
          <span>₹0</span>
          <span>₹10,000</span>
        </div>
        <input type="hidden" id="priceHidden" name="price" value="0">
      </div>

      <!-- Ratings Filter -->
      <div class="mb-4">
        <h6 class="fw-bold">Ratings</h6>
        <ul class="list-unstyled">
          <li><input type="radio" class="form-check-input me-2" name="rating" id="rating5" value="5"> <label for="rating5">5 Stars</label></li>
          <li><input type="radio" class="form-check-input me-2" name="rating" id="rating4" value="4"> <label for="rating4">4 Stars & Above</label></li>
          <li><input type="radio" class="form-check-input me-2" name="rating" id="rating3" value="3"> <label for="rating3">3 Stars & Above</label></li>
        </ul>
      </div>

      <!-- Apply Filters Button -->
      <button type="submit" class="btn button w-100 mt-3">Apply Filters</button>
    </form>
  </div>
</div>

<script>
  document.getElementById('priceRange').addEventListener('input', function() {
    document.getElementById('priceHidden').value = this.value;
  });
</script>
