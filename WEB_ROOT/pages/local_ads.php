      <!-- LOCAL ADS -->
      <div class="content-section">
        <div class="section-header">
          <h2>Local Ads</h2> 

        </div>
        <div id="local-ads" class="ads-grid">
        </div>
      </div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const featuredContainer = document.getElementById('local-ads');

    fetch('/api/get_all_active_ads.php')
      .then(response => response.json())
      .then(featuredData => {
        if (!Array.isArray(featuredData) || featuredData.length === 0) {
          featuredContainer.innerHTML = '<p>No featured posts available.</p>';
          return;
        }
        const html = featuredData.map(ad => {
          const img = (Array.isArray(ad.images) && ad.images.length) ? ad.images[0] : 'https://via.placeholder.com/300x200?text=No+Image';
          const price = (ad.ad_price === 0 || ad.ad_price === '0') ? 'Free' : `£${ad.ad_price}`;
          return `
            <div class="ad-card">
              <img src="${img}" alt="${ad.ad_title} Image of the Product">
              <div class="ad-card-body">
                <div class="ad-card-title">${ad.ad_title}</div>
                <div class="ad-card-price">${price}</div>
                <div class="ad-card-location">📍 ${ad.location || ''}</div>
                <div class="ad-card-desc">${ad.ad_description || ''}</div>
                <a href="/?page=open_ad&id=${ad.id}" class="btn btn-primary">open ad</a>
              </div>
            </div>`;
        }).join('');
        featuredContainer.innerHTML = html;
      })
      .catch(error => {
        console.error('Error fetching featured IDs or ads:', error);
        featuredContainer.innerHTML = '<p>Error loading featured posts.</p>';
      });
  });
</script>