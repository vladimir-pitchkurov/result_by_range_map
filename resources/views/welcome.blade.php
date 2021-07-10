<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full Stack Developer practical test</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
<div id="settings_block">
    <div class="list">
        <label for="places_list">Select a speed</label>
        <select name="places_list" id="places_list">
            @foreach($places as $place)
                <option value="{{$place['id']}}">{{$place['title']}}</option>
            @endforeach
        </select>
    </div>
    <div class="range">
        <div id="slider">
            <div id="custom-handle" class="ui-slider-handle"></div>
        </div>
    </div>
</div>
<div id="result_block">

</div>


<script src="{{mix('js/app.js')}}"></script>
</body>
</html>
