      <!-- POST AN AD -->
      <div class="content-section">
        <div class="section-header">
          <h2>Post An Ad</h2>
        </div>

        <form class="post-ad-form" action="#">
          <div class="post-ad-grid">
             <!-- row 1 (concat into 1stname_2ndname -->
            <div class="form-group first-name-field"><!-- left -->
              <label for="firstName">First name</label>
              <input type="text" id="firstName" name="firstName" placeholder="John">
            </div>

            <div class="form-group last-name-field">
              <label for="lastName">Surname</label><!-- right-->
              <input type="text" id="lastName" name="lastName" placeholder="Doe">
            </div>
            <!-- row 2 -->
            <div class="form-group category-field"> <!-- left -->
              <label for="bigCategory">Category</label>
              <select id="bigCategory" name="bigCategory">
                <option value="">Select category</option>
                <option value="for-sale">For Sale</option>
                <option value="housing">Housing</option>
                <option value="jobs">Jobs</option>
                <option value="services">Services</option>
                <option value="community">Community</option>
                <option value="craiglist">Craiglist</option>
              </select>
            </div>
            <div class="form-group category-field">
                <!-- placeholder for applicable list of subcategories -->
            </div>
            <div class="form-group">
              <label for="price">Price (£)</label>
              <input type="text" id="price" name="price" placeholder="900">
            </div>

            <div class="form-group">
              <label for="location">Location</label>
              <input type="text" id="location" name="location" placeholder="eg. Camden, London">
            </div>

            <div class="form-group form-span-2">
              <label for="description">Description</label>
              <textarea id="description" name="description" placeholder="Add key details about your ad..."></textarea>
            </div>
          </div>

          <div class="photo-upload-row">
            <div class="photo-upload-title">Upload photos</div>
            <div class="profile-picture">
              <h1 class="upload-icon"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></h1>
              <input class="file-uploader" id="images" name="images[]" type="file" accept="image/*" multiple>
            </div>
          </div>

          <div class="post-ad-actions">
            <button type="submit" class="btn btn-primary">publish ad</button>
            <button type="button" class="btn btn-secondary">save draft</button>
          </div>
        </form>
      </div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const propertyType = document.getElementById('propertyType');
    const bigCategory = document.getElementById('bigCategory');
    const subCategory = document.getElementById('subCategory');
    const form = document.querySelector('.post-ad-form');
    const fileInput = document.getElementById('images');

    function syncPropertyFieldState() {
      const isHousing = bigCategory && bigCategory.value === 'housing';
      if (propertyType) propertyType.disabled = !isHousing;
      if (!isHousing && propertyType) {
        propertyType.value = '';
      }
    }

    if (bigCategory) {
      bigCategory.addEventListener('change', syncPropertyFieldState);
      syncPropertyFieldState();
    }

    async function fileToDataUrl(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.onerror = reject;
        reader.readAsDataURL(file);
      });
    }

    const categoryMap = {
      'for-sale': [
        'antiques','appliances','bikes','books','cars & vans','clothes','electronics','furniture','free stuff'
      ],
      'housing': [
        'flats to rent','rooms wanted','houses for sale','short-term lets','flatshares','commercial','parking'
      ],
      'jobs': [
        'accounting','admin / office','creative / design','education','hospitality','part time','tech / IT'
      ],
      'services': [
        'beauty','childcare','cleaning','financial','lessons & tutoring','moving','pet care'
      ],
      'community': [
        'activities','events','groups','local news','missed connections','volunteers'
      ],
      'craiglist': [
        'about us','blog','safety tips','avoid scams','help & FAQ','contact us'
      ]
    };

    function populateSubcategories(key) {
      subCategory.innerHTML = '';
      const defaultOpt = document.createElement('option');
      defaultOpt.value = '';
      defaultOpt.textContent = 'Select subcategory';
      subCategory.appendChild(defaultOpt);
      if (!key || !categoryMap[key]) {
        subCategory.disabled = true;
        return;
      }
      categoryMap[key].forEach(item => {
        const opt = document.createElement('option');
        opt.value = item;
        opt.textContent = item;
        subCategory.appendChild(opt);
      });
      subCategory.disabled = false;
    }

    if (bigCategory) {
      bigCategory.addEventListener('change', () => populateSubcategories(bigCategory.value));
      // optionally populate if a value already selected
      if (bigCategory.value) populateSubcategories(bigCategory.value);
    }

    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      const ad_title = document.getElementById('adTitle').value.trim();
      const ad_description = document.getElementById('description').value.trim();
      const ad_price = document.getElementById('price').value.trim() || '0';
      const location = document.getElementById('location').value.trim();

      if (!ad_title || !ad_description || !location) {
        alert('Please complete title, description and location.');
        return;
      }

      const images = [];
      if (fileInput && fileInput.files && fileInput.files.length) {
        for (let i = 0; i < fileInput.files.length; i++) {
          try {
            const dataUrl = await fileToDataUrl(fileInput.files[i]);
            images.push(dataUrl);
          } catch (err) {
            console.error('Failed to read file', err);
          }
        }
      }

      const firstName = document.getElementById('firstName').value.trim();
      const lastName = document.getElementById('lastName').value.trim();
      const creation_user = (firstName || lastName) ? (firstName + '_' + lastName).toLowerCase() : '';

      const payload = {
        ad_title,
        ad_description,
        ad_price,
        location,
        images,
        creation_user,
        ad_category: subCategory && subCategory.value ? subCategory.value : (bigCategory ? bigCategory.value : ''),
        ad_subcategory: ''
      };

      try {
        const resp = await fetch('/api/create_ad.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const result = await resp.json();
        if (resp.ok && result.success) {
          alert('Ad created: ' + result.ad_id);
          window.location.href = '/';
        } else {
          alert('Failed to create ad: ' + (result.error || 'unknown error'));
        }
      } catch (err) {
        console.error(err);
        alert('Network error when creating ad');
      }
    });
  });
</script>

