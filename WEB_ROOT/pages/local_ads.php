      <!-- LOCAL ADS
           - Shows locally active ads in a responsive grid.
           - Data is fetched from `/api/get_all_active_ads.php` and rendered into `#local-ads`.
           - Note: server should return safe JSON; escape/validate server-side in production.
      -->
            <div class="content-section">
              <div class="section-header">
                <h2>Local Ads</h2>
              </div>
              <!-- Container for the ads grid: populated by JS -->
              <div id="local-ads" class="ads-grid"></div>
            </div>


      <script>
        // Load and render local ads on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
          const featuredContainer = document.getElementById('local-ads');

          // Fetch all active ads (JSON). Keep rendering simple for demo purposes.
          fetch('/api/get_all_active_ads.php')
            .then(response => response.json())
            .then(featuredData => {
              // If no data, show a friendly message
              if (!Array.isArray(featuredData) || featuredData.length === 0) {
                featuredContainer.innerHTML = '<p>No local posts available.</p>';
                return;
              }

              // Build HTML for each ad. In production prefer DOM methods or templating + proper escaping.
              const html = featuredData.map(ad => {
                const img = (Array.isArray(ad.images) && ad.images.length) ? ad.images[0] : 'https://via.placeholder.com/300x200?text=No+Image';
                const price = (ad.ad_price === 0 || ad.ad_price === '0') ? 'Free' : `£${ad.ad_price}`;
                return `
                  <div class="ad-card">
                    <img src="${img}" alt="${(ad.ad_title || 'Listing')} image">
                    <div class="ad-card-body">
                      <div class="ad-card-title">${ad.ad_title || ''}</div>
                      <div class="ad-card-price">${price}</div>
                      <div class="ad-card-location">📍 ${ad.location || ''}</div>
                      <div class="ad-card-desc">${ad.ad_description || ''}</div>
                      <a href="/?page=open_ad&id=${ad.id}" class="btn btn-primary">open ad</a>
                    </div>
                  </div>`;
              }).join('');

              // Insert into the grid
              featuredContainer.innerHTML = html;
            })
            .catch(error => {
              // Log for debugging and show a concise error message to users
              console.error('Error fetching local ads:', error);
              featuredContainer.innerHTML = '<p>Error loading local posts.</p>';
            });
        });
      </script>