      <!-- FEATURED POSTS -->
      <div class="content-section">
        <div class="section-header">
          <h2>Featured Posts</h2> 

        </div>
        <div id="featured-posts" class="ads-grid">
        </div>
      </div>

      <!-- FEATURED SELLERS -->
      <div class="content-section">
        <div class="section-header">
          <h2>Featured Sellers</h2>
        </div>
        <div class="sellers-grid">
          <div class="seller-card">
            <h5>Alice's Antiques</h5>
            <p>⭐⭐⭐⭐⭐ — Top-rated seller in London<br>Specialising in Victorian furniture & glassware.</p>
          </div>
          <div class="seller-card">
            <h5>Bob's Bikes</h5>
            <p>⭐⭐⭐⭐⭐ — Trusted local seller<br>Refurbished cycles, parts & accessories.</p>
          </div>
          <div class="seller-card">
            <h5>Zara's Vintage</h5>
            <p>⭐⭐⭐⭐½ — Verified seller<br>Pre-loved fashion from the 60s–90s, Portobello Road.</p>
          </div>
          <div class="seller-card">
            <h5>TechFlip London</h5>
            <p>⭐⭐⭐⭐⭐ — Fast responder<br>Refurbished electronics, 30-day returns guaranteed.</p>
          </div>
        </div>
      </div>

      <!-- LOCAL ADS -->
      <div class="content-section">
        <div class="section-header">
          <h2>Local Ads</h2>
        </div>
        <div class="ads-grid">

          <div class="ad-card">
            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=300&q=80" alt="Flat for Rent">
            <div class="ad-card-body">
              <div class="ad-card-title">1-Bed Flat for Rent</div>
              <div class="ad-card-price">£900/mo</div>
              <div class="ad-card-location">📍 Brixton, London</div>
              <div class="ad-card-desc">Top-floor flat, bright & airy, 5 min walk to Brixton station. No DSS.</div>
              <a href="#" class="btn btn-primary">contact landlord</a>
            </div>
          </div>

          <div class="ad-card">
            <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=300&q=80" alt="Dog Walking">
            <div class="ad-card-body">
              <div class="ad-card-title">Dog Walking Service</div>
              <div class="ad-card-price">£10/hr</div>
              <div class="ad-card-location">📍 Hackney, London</div>
              <div class="ad-card-desc">Reliable, insured, DBS-checked. Solo walks available. Any breed welcome.</div>
              <a href="#" class="btn btn-primary">get in touch</a>
            </div>
          </div>

          <div class="ad-card">
            <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=300&q=80" alt="Yoga Classes">
            <div class="ad-card-body">
              <div class="ad-card-title">Yoga Classes — All Levels</div>
              <div class="ad-card-price">£12/class</div>
              <div class="ad-card-location">📍 Peckham, London</div>
              <div class="ad-card-desc">Morning & evening sessions, small groups max 8 people. First class free.</div>
              <a href="#" class="btn btn-primary">book now</a>
            </div>
          </div>

          <div class="ad-card">
            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=300&q=80" alt="Handyman">
            <div class="ad-card-body">
              <div class="ad-card-title">Handyman — All Jobs</div>
              <div class="ad-card-price">£25/hr</div>
              <div class="ad-card-location">📍 Lewisham, London</div>
              <div class="ad-card-desc">Plumbing, electrics, painting, flat-pack assembly. Fully insured, refs available.</div>
              <a href="#" class="btn btn-primary">call Dave</a>
            </div>
          </div>

        </div>
      </div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const featuredContainer = document.getElementById('featured-posts');

    fetch('/api/get_featured.php')
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
              <img src="${img}" alt="${ad.ad_title}">
              <div class="ad-card-body">
                <div class="ad-card-title">${ad.ad_title}</div>
                <div class="ad-card-price">${price}</div>
                <div class="ad-card-location">📍 ${ad.location || ''}</div>
                <div class="ad-card-desc">${ad.ad_description || ''}</div>
                <a href="#" class="btn btn-primary">contact</a>
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