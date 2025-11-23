<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="{{ url()->previous() }}">Back</a>
    <p>Password = "password"</p>
    <p>L001 = admin</p>
    Students:
    <ol>
        @foreach ($students as $s)
            <li>{{ $s->student_number }} - {{ $s->full_name }}</li>
        @endforeach
    </ol>
    Lecturer:
    <ol>
        @foreach ($lecturers as $l)
            <li>{{ $l->lecturer_code }} - {{ $l->lecturer_name }}</li>
        @endforeach
    </ol>
</body>

</html>