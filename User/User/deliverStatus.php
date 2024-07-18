    <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $status = $_POST["status"];
        // Store the current status in a session variable
        $_SESSION["current_status"] = $status;
        echo "Status: " . $status;
    }
    ?>
    <style>

        /* vars */
    :root {
    --back: #eeeeee;
        --blue: #0082d2;
        --green: #33DDAA;
    --gray: #777777;
    --size: 200px;  
    }

    body, html {
    background: var(--back);
        padding: 0;
        margin: 0;
    font-family: sans-serif;
    color: var(--gray);
    }
    .tracking-wrapper {
        margin: 30px;
    padding: 0;
    }
    .tracking * {
        padding: 0;
        margin: 0;
    }
    .tracking {
        width: var(--size);
        max-width: 100%;
        position: relative;
    }
    .tracking .empty-bar {
        background: #ddd;
        position: absolute;
        width: 90%;
        height: 20%;
        top: 40%;
        margin-left: 5%;
    }
    .tracking .color-bar {
        background: var(--blue);
        position: absolute;
        height: 20%;
        top: 40%;
        margin-left: 5%;
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
        -ms-transition: all 0.5s;
        -o-transition: all 0.5s;
    }
    .tracking ul {
        display: flex;
        justify-content: space-between;
        list-style: none;
    }
    .tracking ul > li {
        background: #ddd;
        text-align: center;
    border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        z-index: 1;
        background-size: 70%;
        background-repeat: no-repeat;
        background-position: center center;
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
        -ms-transition: all 0.5s;
        -o-transition: all 0.5s;
        display: inline-block;
        position: relative;
        width: 10%;
    }
    .tracking ul > li .el {
        position: relative;
    margin-top: 100%;
    }
    .tracking ul > li .el i {
    position: absolute;
    bottom: 100%;
    left: 8%;
    margin-bottom: 12%;
    color: #fff;
    font-size: 100%;
    display: none;
    }
    .tracking ul > li .txt {
    color: #999;
        position: absolute;
        top: 120%;
        left: -75%;
        text-align: center;
        width: 250%;
        font-size: .75rem;
    }
    .tracking .progress-0 .color-bar { width: 00%; }
    .tracking .progress-1 .color-bar { width: 30%; }
    .tracking .progress-2 .color-bar { width: 60%; }
    .tracking .progress-3 .color-bar { width: 90%; }
    .tracking .progress-4 .color-bar { width: 90%; }

    .tracking .progress-0 > ul > li.bullet-1,
    .tracking .progress-1 > ul > li.bullet-1,
    .tracking .progress-2 > ul > li.bullet-1,
    .tracking .progress-3 > ul > li.bullet-1,
    .tracking .progress-4 > ul > li.bullet-1
    { background-color: var(--blue); }

    .tracking .progress-1 > ul > li.bullet-2,
    .tracking .progress-2 > ul > li.bullet-2,
    .tracking .progress-3 > ul > li.bullet-2,
    .tracking .progress-4 > ul > li.bullet-2
    { background-color: var(--blue); }

    .tracking .progress-2 > ul > li.bullet-3,
    .tracking .progress-3 > ul > li.bullet-3,
    .tracking .progress-4 > ul > li.bullet-3
    { background-color: var(--blue); }


    .tracking .progress-3 > ul > li.bullet-4,
    .tracking .progress-4 > ul > li.bullet-4    
    { background-color: var(--blue); }

    .tracking .progress-4 > ul > li.bullet-4    
    { background-color: var(--green); }

    .tracking .progress-1 > ul > li.bullet-1 .el i,
    .tracking .progress-2 > ul > li.bullet-1 .el i,
    .tracking .progress-3 > ul > li.bullet-1 .el i,
    .tracking .progress-4 > ul > li.bullet-1 .el i
    { display: block; }

    .tracking .progress-2 > ul > li.bullet-2 .el i,
    .tracking .progress-3 > ul > li.bullet-2 .el i,
    .tracking .progress-4 > ul > li.bullet-2 .el i
    { display: block; }

    .tracking .progress-3 > ul > li.bullet-3 .el i,
    .tracking .progress-4 > ul > li.bullet-3 .el i
    { display: block; }

    .tracking .progress-4 > ul > li.bullet-4 .el i
    { display: block; }

    .tracking .progress-1 > ul > li.bullet-1 .txt,
    .tracking .progress-2 > ul > li.bullet-1 .txt,
    .tracking .progress-3 > ul > li.bullet-1 .txt
    { color: var(--blue); }

    .tracking .progress-2 > ul > li.bullet-2 .txt,
    .tracking .progress-3 > ul > li.bullet-2 .txt,
    { color: var(--blue); }

    .tracking .progress-3 > ul > li.bullet-3 .txt,
    { color: var(--blue); }


    /* demo */
    .controls {
    margin: 90px 30px 30px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    }
    .controls > div {
    display: flex;
    justify-content: flex-start;
    align-items: space-between;
    margin: 0;
    padding: 0;
    }
    .controls p,
    .controls button {
    border: 0;
    line-height: 20px;
    padding: 15px;
    font-size: 0.8rem;
    text-transform: uppercase;
    }
    .controls button {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0 6px;
    background: var(--blue);
    color: #fff;
    border-radius: 50px;
    transition: all .3s;
    }
    .controls button:nth-child(1) {
    margin-left: 0;
    }
    .controls button i {
    font-size: 1rem;
    margin: 0 5px;
    }
    .controls button#prev { padding-right: 30px; }
    .controls button#next { padding-left: 30px; }

    .controls button:hover,
    .controls button:focus {
    outline: none;
    background-color: var(--green);
    }
    </style>
    <div class="tracking-wrapper">
    <div class="tracking">
        <div id="progress" class="progress-0">
        <div class="empty-bar"></div>
        <div class="color-bar"></div>
        <ul>
            <li class="bullet-1">
            <div class="el"><i class='bx bx-check'></i></div>
            <div class="txt">Order Processed</div>
            </li>
            <li class="bullet-2">
            <div class="el"><i class='bx bx-check'></i></div>
            <div class="txt">Order Shipped</div>
            </li>
            <li class="bullet-3">
            <div class="el"><i class='bx bx-check'></i></div>
            <div class="txt">Order En Route</div>
            </li>
            <li class="bullet-4">
            <div class="el"><i class='bx bx-check'></i></div>
            <div class="txt">Order Arrived</div>
            </li>
        </ul>
        </div>
    </div>
    </div>

    <div class="controls">
    <div>
    <form id="statusForm" method="POST" action="deliverStatus.php">
        <input type="hidden" id="statusInput" name="status" value="Order Processed">
        </form>
        <button id="prev"><i class='bx bx-chevron-left'></i> Prev</button>
        <button id="next">Next <i class='bx bx-chevron-right'></i></button>
    </div>
    <div>
        <p>Step: <span id="step">0</span></p>
    </div>
    </div>

    <script>
    var prev = document.getElementById('prev');
    var next = document.getElementById('next');
    var trak = document.getElementById('progress');
    var step = document.getElementById('step');

    next.addEventListener('click', function () {
        var cls = trak.className.split('-').pop();
        cls > 6 ? cls = 0 : cls++;

        step.innerHTML = cls;
        trak.className = 'progress-' + cls;

        // Update the status input field
        var statusInput = document.getElementById('statusInput');
        statusInput.value = getStatusText(cls);

        // Submit the form
        document.getElementById('statusForm').submit();
    });

    prev.addEventListener('click', function () {
        var cls = trak.className.split('-').pop();

        // Check if there's a previous status stored in the session
        if (cls > 0) {
            cls--;
        }

        step.innerHTML = cls;
        trak.className = 'progress-' + cls;

        // Update the status input field
        var statusInput = document.getElementById('statusInput');
        statusInput.value = getStatusText(cls);

        // Submit the form
        document.getElementById('statusForm').submit();
    });

    function getStatusText(cls) {
    switch (cls) {
        case 0:
            return 'Order Processed';
        case 1:
            return 'Order Shipped';
        case 2:
            return 'Order En Route';
        case 3:
            return 'Order Arrived';
        default:
            return 'Order Processed';
    }
}

    // Initialize the status and form
    document.addEventListener('DOMContentLoaded', function () {
        var initialStatus = "<?php echo isset($_SESSION['current_status']) ? $_SESSION['current_status'] : 'Order Processed'; ?>";
        var initialStep = getStatusStep(initialStatus);
        step.innerHTML = initialStep;
        trak.className = 'progress-' + initialStep;
        var statusInput = document.getElementById('statusInput');
        statusInput.value = initialStatus;
    });

    function getStatusStep(status) {
        switch (status) {
            case 'Order Processed':
                return 0;
            case 'Order Shipped':
                return 1;
            case 'Order En Route':
                return 2;
            case 'Order Arrived':
                return 3;
            default:
                return 0;
        }
    }
    </script>