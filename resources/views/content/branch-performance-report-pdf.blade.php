<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        td:first-child {
            text-align: left;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
            position: absolute;
            top: 15px;
            left: 30px;
        }

        .logo img {
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="{{ public_path('img/logo.jpg') }}" alt="Logo">
    </div>

    <h4 style="text-align: center; margin-bottom: 10px;">MMML Recruitment Agency</h4>
    @if ($user->position == 'Admin')
        <p style="text-align: center; margin-bottom: 5px;">GF-4F, ALA Bldg, 1112 Quirino Avenue, Malate, Manila</p>
        <p style="text-align: center; margin-bottom: 20px;">NCR</p>
    @else
        <p style="text-align: center; margin-bottom: 5px;">
            {{ $user->branch->postal_code . ' ' . $user->branch->street . ' ' . $user->branch->barangay . ' ' . $user->branch->municipality }}
        </p>
        <p style="text-align: center; margin-bottom: 20px;">{{ $user->branch->region }}</p>
    @endif

    <div style="border-top: 1px solid #000; margin: 20px 0;"></div>

    @if (isset($branch))
        <p style="text-align: center;">{{ $branch }}</p>
    @endif

    <h3 style="text-align: center; margin-top: 20px;">Branch Performance Report</h3>
    <p style="text-align: center; margin-top: 0;">{{ \Carbon\Carbon::parse($startDate)->format('F j, Y') }} -
        {{ \Carbon\Carbon::parse($endDate)->format('F j, Y') }}</p>
    <p style="text-align: center;">

    </p>

    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Branch Name</th>
                <th scope="col">Total Applications</th>
                <th scope="col">Hired Applications</th>
                <th scope="col">Deployed Applications</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($report as $record)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $record['branch'] }}</td>
                    <td>{{ $record['total_applications'] }}</td>
                    <td>{{ $record['hired_applications'] }}</td>
                    <td>{{ $record['deployed_applications'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No record found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        <h4 style=" margin-bottom: 10px;">Prepared by:</h4>
        <h3 style=" margin-bottom: 1px;">
            {{ Auth::guard('employee')->user()->first_name }}
            @if (Auth::guard('employee')->user()->middle_name)
                {{ Auth::guard('employee')->user()->middle_name[0] }}.
            @endif
            {{ Auth::guard('employee')->user()->last_name }}
        </h3>
        <p style="font-size: 14px">{{ ucfirst(Auth::user()->role) }}</p>
        <p style="font-size: 14px">Generated on: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    </div>
</body>

</html>
