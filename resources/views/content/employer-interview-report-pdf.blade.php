<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Interview Report</title>
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
            left: 50px;
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
    <p style="text-align: center; margin-bottom: 5px;">Koronadal City, South Cotabato</p>
    <p style="text-align: center; margin-bottom: 20px;">Region XII</p>

    <div style="border-top: 1px solid #000; margin: 20px 0;"></div>

    <h3 style="text-align: center; margin-top: 20px;">Employer Interview Report</h3>
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
                <th>Rating</th>
                <th>Interview Date</th>
                <th>Interviewer/Employer</th>
                <th>Result/Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($report as $record)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $record['applicant_name'] }}</td>
                    <td>{{ $record['branch'] }}</td>
                    <td>{{ $record['job_title'] }}</td>
                    <td>{{ $record['rating'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($record['interview_date'])->format('F j, Y') }}</td>
                    <td>{{ $record['interviewer'] }}</td>
                    <td>{{ $record['remarks'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No record found</td>
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
