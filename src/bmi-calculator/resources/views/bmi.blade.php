<!DOCTYPE html>
<html>
<head>
    <title>BMI Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow">
            <h2 class="mb-4">BMI Calculator</h2>
            <form method="POST" actions="/bmi">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Weight (kg):</label>
                    <input type="number" step="0.1" name="weight" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Height (cm):</label>
                    <input type="number" step="1" name="height" class="form-control" required>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" class="btn btn-primary">Calculate</button>
                </div>
            </form>
            <br><br>
            @if ($errors->any())
                <div class="alert alert-danger mt-4">
                    <h6><strong>Errors:</strong></h6>
                    <ul class="list-group">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @isset($bmi)
                @if($bmi < 18.5)
                    <div class="alert alert-primary mt-4">
                        Your BMI is: <strong>{{ $bmi }} (underweight)</strong>
                    </div>
                @elseif($bmi < 24.9)
                    <div class="alert alert-success mt-4">
                        Your BMI is: <strong>{{ $bmi }} (normal weight)</strong>
                    </div>
                @else
                    <div class="alert alert-warning mt-4">
                        Your BMI is: <strong>{{ $bmi }} (overweight)</strong>
                    </div>
                @endif
            @endisset
        </div>
    </div>
</body>
</html>
