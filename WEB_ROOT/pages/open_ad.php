<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0
">    <title>Ad Details</title>
    <link rel="stylesheet" href="wireframe.css">
</head>
<body>
    <div class="content-section" style="max-width: 44vw;">
        <div class="section-header">
            <h2>Ad Details</h2>
        </div>
        <div id="ad-details" class="ad-card" >
            <p>Loading...</p>
        </div>
    </div> 
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const adId = new URLSearchParams(window.location.search).get('id');
    const adDetailsContainer = document.getElementById('ad-details');   
    if (!adId) {
      adDetailsContainer.innerHTML = '<p>Ad ID is required.</p>';
      return;
    }
    fetch(`/api/get_ad.php?id=${encodeURIComponent(adId)}`)
        .then(response => response.json())
        .then(ad => {
            if (ad.error) {
                adDetailsContainer.innerHTML = `<p>${ad.error}</p>`;
                return;
            }
            const img = (Array.isArray(ad.images) && ad.images.length) ? ad.images[0] : 'https://via.placeholder.com/600x400?text=No+Image';
            const price = (ad.ad_price === 0 || ad.ad_price === '0') ? 'Free' : `£${ad.ad_price}`;
            adDetailsContainer.innerHTML = `
                <img src="${img}" alt="${ad.ad_title}" style="max-width:50vw; height:auto;">
                <div class="ad-card-body">
                    <div class="ad-card-title">${ad.ad_title}</div>
                    <div class="ad-card-price">${price}</div>
                    <div class="ad-card-location">📍 ${ad.location || ''}</div>
                    <div class="ad-card-desc">${ad.ad_description || ''}</div>
                    <a href="mailto:${ad.seller_email || 'unknown@ craigslist.org'}" class="btn btn-primary">contact</a>
                </div>`;
        })
        .catch(error => {
            console.error('Error fetching ad details:', error);
            adDetailsContainer.innerHTML = '<p>Error loading ad details.</p>';
        });
  });
</script>
</body></html>