window.addEventListener("load", (e) => {
  processForm();
});

function processForm() {
  document.getElementById('metricForm').addEventListener('submit', function (e) {
    e.preventDefault();
  
    let formData = new FormData(this);
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  
    // Convert checkbox values to an array
    let categories = [];
    document.querySelectorAll('input[name="categories[]"]:checked').forEach(checkbox => {
        categories.push(checkbox.value);
    });
  
    // Construct an object with form field values
    let data = {
        url: formData.get('url'),
        strategy: formData.get('strategy'),
        categories: categories
    };
  
    fetch(window.routes.getMetrics, {
        method: 'POST',
        body: JSON.stringify(data), // Send the data as JSON
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            return response.json().then(errors => {
                throw errors;
            });
        }
    })
    .then(data => {
        let results = document.getElementById('results');
        results.innerHTML = '';
        let metrics = data.metrics;
        for (let key in metrics) {
            results.innerHTML += `<p>${key}: ${metrics[key] !== null ? metrics[key] : 'N/A'}</p>`;
        }
        document.getElementById('saveMetrics').style.display = 'block';
    })
    .catch(errors => {
        // Handle validation errors
        console.error('Validation errors:', errors);
        // Example: Display errors to the user
        alert('Validation errors: ' + JSON.stringify(errors));
    });
  });
}
