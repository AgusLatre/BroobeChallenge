<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broobe Tech Test</title>
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.routes = {
            getMetrics: "{{ route('get.metrics') }}",
            saveMetricRun: "{{ route('save.metric.run') }}"
        };
    </script>
</head>
<body>
    <div class="container">
        <h1>Broobe Challenge</h1>
        <form id="metricForm" class="flex f-d-r">
            <div class="form-group url">
                <label for="url">URL:</label>
                <input type="text" id="url" name="url" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Categories:</label>
                <div class="categories">
                    @foreach($categories as $category)
                        <div class="form-check">
                            <input type="checkbox" name="categories[]" value="{{ $category->name }}" class="form-check-input">
                            <label class="form-check-label">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group strat">
                <label for="strategy">Strategy:</label>
                <select id="strategy" name="strategy" class="form-control" required>
                    @foreach($strategies as $strategy)
                        <option value="{{ $strategy->name }}">{{ $strategy->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Get Metrics</button>
        </form>
        <div id="results" class="mt-4 results"></div>
        <button id="saveMetrics" class="btn btn-success mt-2" style="display: none;">Save Metric Run</button>
    </div>

    <script>
        document.getElementById('metricForm').addEventListener('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let categories = [];
            document.querySelectorAll('input[name="categories[]"]:checked').forEach(checkbox => {
                categories.push(checkbox.value);
            });

            let data = {
                url: formData.get('url'),
                strategy: formData.get('strategy'),
                categories: categories
            };

            fetch(window.routes.getMetrics, {
                method: 'POST',
                body: JSON.stringify(data),
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
                    results.innerHTML += `<p>${key}: <br>${metrics[key] !== null ? metrics[key] : 'N/A'}</p>`;
                }
                document.getElementById('saveMetrics').style.display = 'block';
            })
            .catch(errors => {
                console.error('Validation errors:', errors);
                alert('Validation errors: ' + JSON.stringify(errors));
            });
        });
    </script>
</body>
</html>
