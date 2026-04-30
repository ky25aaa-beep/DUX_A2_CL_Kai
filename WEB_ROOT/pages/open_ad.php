<!-- OPEN AD PAGE
         - Accessible single-ad view with optional lazy-loaded map
         - URL: ?page=open_ad&id={ad_id}
-->

<div class="content-section" style="max-width:900px;margin:0 auto;"> <!-- constrain width for readability -->

    <div class="section-header">
        <h2>Ad Details</h2>
    </div>

    <!-- Ad details container: populated by JS after fetching /api/get_ad.php -->
    <div id="ad-details" class="ad-card">
        <p>Loading...</p>
    </div>

    <div class="content-section" style="margin-top:1rem;">
        <div class="section-header"><h2>Messages</h2></div> <!-- Messages section header -->

        <!-- Messages thread: demo content inserted by JS -->
        <div id="messages-thread" class="messages-thread"></div>

        <!-- Message compose area is intentionally disabled in this demo -->
        <div class="message-compose">
            <textarea disabled placeholder="Demo messages only"></textarea>
            <button disabled class="btn btn-primary">Reply</button>
        </div>
    </div>

</div>

<script>
// Page script: fetch ad data, render details safely, and toggle an embedded map on demand
document.addEventListener("DOMContentLoaded", function(){

    const adId = new URLSearchParams(window.location.search).get("id");
    const adDetails = document.getElementById("ad-details");
    const messages = document.getElementById("messages-thread");

    // Small helper to escape user-provided text before injecting into the DOM
    function escapeHtml(str){
        return String(str || "")
            .replace(/&/g,"&amp;")
            .replace(/</g,"&lt;")
            .replace(/>/g,"&gt;")
            .replace(/\"/g,"&quot;")
            .replace(/'/g,"&#039;");
    }

    if(!adId){
        adDetails.innerHTML = "<p>Ad ID required</p>";
        return;
    }

    // Fetch ad JSON from server and build the details block.
    // Note: images may be data URLs or remote URLs; placeholder used if none.
    fetch(`/api/get_ad.php?id=${encodeURIComponent(adId)}`)
        .then(r => r.json())
        .then(ad => {
            const img = ad.images?.[0] || "https://via.placeholder.com/900x600?text=No+Image";
            const price = ad.ad_price == 0 ? "Free" : `£${escapeHtml(ad.ad_price)}`;
            const seller = ad.creation_user || "Seller";
            const location = ad.location || "";

            // Render a semantic card: title, image, price, location, description, metadata
            adDetails.innerHTML = `
                <img src="${img}" style="width:100%; height:100%" alt="${escapeHtml(ad.ad_title)} image">
                <div class="ad-card-body">
                    <div class="ad-card-title">${escapeHtml(ad.ad_title)}</div>
                    <div class="ad-card-price">${price}</div>
                    <div style="cursor:pointer;" id="ad-location" class="ad-card-location" data-location="${escapeHtml(location)}">${escapeHtml(location)} {click to view on map}</div>

                    <!-- Map iframe is lazy-loaded and hidden until user requests it by clicking the location -->
                    <div id="map" style="display:none;margin-top:8px">
                        <iframe id="mapframe" width="100%" height="300" style="border:0" loading="lazy"></iframe>
                    </div>

                    <div class="ad-card-title">Description</div>
                    <div class="ad-card-desc">${escapeHtml(ad.ad_description)}</div>

                    <p style="font-size:12px;color:#555">
                        <strong>Seller:</strong> ${escapeHtml(seller)}<br>
                        <strong>Posted:</strong> ${escapeHtml(ad.created_at)}<br>
                        <strong>Category:</strong> ${escapeHtml(ad.ad_category)} / ${escapeHtml(ad.ad_subcategory)}
                    </p>
                </div>
            `;

            // Demo messages: simple static thread to show layout (replace with real chat in production)
            messages.innerHTML = `
                <div class="seller-card message-buyer">
                    <h5>Joe (Buyer)</h5>
                    <p>Hi — is this still available?</p>
                </div>
                <div class="seller-card message-seller">
                    <h5>${escapeHtml(seller)}</h5>
                    <p>Yes it is. Come by this weekend to view.</p>
                </div>
            `;
        })
        .catch(() => {
            adDetails.innerHTML = "<p>Error loading ad</p>";
        });

});


/* Map toggle behaviour
     - Clicking the location element toggles a hidden map container
     - The iframe src is set lazily the first time to avoid unnecessary external requests
*/
document.addEventListener("click", function(e){
    const loc = e.target.closest("#ad-location");
    if(!loc) return; // only proceed if a location element was clicked

    const map = document.getElementById("map"); // container to show/hide
    const frame = document.getElementById("mapframe"); // iframe to set src on first toggle
    const location = loc.dataset.location; // get the location from the data attribute

    if(!frame.src){
        frame.src = `https://www.google.com/maps?q=${encodeURIComponent(location)}&z=14&output=embed`;
    } // SET IFRAME SRC ON FIRST TOGGLE - this could be switched to onload in real implementation to ensure the map is ready before showing

    map.style.display = map.style.display === "block" ? "none" : "block"; // TOGGLE MAP VISIBILITY 
});
</script>