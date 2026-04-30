<?php
$searchQuery = $_GET['q'] ?? ''; # $ searchQuery is set to the 'q' parameter from the URL, or an empty string if 'q' is not provided
?>
<div class="content-section"> <!
  <div class="section-header">
    <h2>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2> <!-- The search query is displayed in the heading, with HTML special characters escaped for security -->
  </div>
  <div class="ads-grid" id="search-results">
    <!-- Search results will be injected here by JavaScript -->
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchQuery = "<?php echo addslashes($searchQuery); ?>";
    if (searchQuery) {
      fetch(`/api/search.php?q=${encodeURIComponent(searchQuery)}`)
        .then(response => response.json())
            .then(data => {
          const resultsContainer = document.getElementById('search-results');
          if (!Array.isArray(data) || data.length === 0) {
            resultsContainer.innerHTML = '<p>No results found.</p>';
            return;
          }
          resultsContainer.innerHTML = data.map(ad => {
            const img = (ad.images && ad.images.length) ? ad.images[0] : '';
            const title = ad.ad_title || ad.title || 'Untitled';
            const desc = ad.ad_description || ad.description || '';
            const price = (ad.ad_price !== undefined) ? ad.ad_price : (ad.price !== undefined ? ad.price : '---');
            const location = ad.location || '';
            return `
              <div class="ad-card">
                <img src="${img}" alt="${title} Image of Product">
                <div class="ad-card-body">
                  <div class="ad-card-title">${title}</div>
                  <div class="ad-card-price">£${price}</div>
                  <div class="ad-card-location">📍 ${location}</div>
                  <div class="ad-card-desc">${desc}</div>
                  <a href="/?page=open_ad&id=${ad.id}" class="btn btn-primary">open ad</a>
                </div>
              </div>
            `;
          }).join('');
        })
        .catch(error => {
          console.error('Error fetching search results:', error);
        });
    }
  });
</script>
