<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hired Applicants Report</title>
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



    <h3 style="text-align: center; margin-top: 20px;">Hired Applicants Report</h3>
    <p style="text-align: center; margin-top: 0;">{{ \Carbon\Carbon::parse($startDate)->format('F j, Y') }} -
        {{ \Carbon\Carbon::parse($endDate)->format('F j, Y') }}</p>
    @if (isset($branch))
        <p style="text-align: center;">{{ $branch }} Branch</p>
    @endif
    <p style="text-align: center;">

    </p>

    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th>Applicant</th>
                <th>Branch</th>
                <th>Job Title</th>
                <th>Date Hired</th>
                <th>Refferal Code</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($report as $record)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $record['applicant_name'] }}</td>
                    <td>{{ $record['branch'] }}</td>
                    <td>{{ $record['job_title'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($record['application_date'])->format('F j, Y') }}</td>
                    <td>{{ $record['referral_code'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No record found</td>
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
