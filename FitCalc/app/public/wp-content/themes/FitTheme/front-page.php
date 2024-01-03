<?php get_header(); ?>

<h1>Hello in FitCalc</h1>
<h3>This website is made with FitTheme Theme</h3>
<p>The Author is Anmar Hani</p>

<hr>
<h3>Input Form</h3>
<form>
    <div>
        <label for="">Name</label>
        <input id="name" type="text" placeholder="Name">
    </div>
    <div>
        <label for="">Age</label>
        <input id="age" type="text" placeholder="Age">
    </div>
    <div>
        <label for="">Weight</label>
        <input id="weight" type="text" placeholder="Weight">
    </div>
    <div>
        <label for="">Height</label>
        <input id="height" type="text" placeholder="Height">
    </div>
    <div>
        <label for="gender">Gender</label>
        <select name="gender" id="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </div>
    <div>
        <label for="">Activity</label>
        <select name="activity" id="activity">
            <option value="rare">Rare</option>
            <option value="low">Low</option>
            <option value="moderate">Moderate</option>
            <option value="high">High</option>
        </select>
    </div>
    <div>
        <label for="">Goal</label>
        <select name="goal" id="goal">
            <option value="lose">Lose</option>
            <option value="maintain">Maintain</option>
            <option value="gain">Gain</option>
        </select>
    </div>
</form>

<hr>

<button onclick="calculate()">Calculate</button>

<h3>Results:</h3>
<?php

$args = array(
    'post_type' => 'Field', // Replace 'custom' with the actual name of your custom post type
    'posts_per_page' => -1 // Adjust the number of posts per page as needed
);

// The Query
$the_query = new WP_Query($args);

// The Loop
if ($the_query->have_posts()) {
    while ($the_query->have_posts()) : $the_query->the_post();
?>
        <h4><strong><?php echo get_field("label"); ?></strong></h4>
        <p id="<?php echo get_field("label"); ?>"></p>
<?php
    endwhile;
}
?>

<script>
    function calculate() {
        <?php

        $args = array(
            'post_type' => 'Field', // Replace 'custom' with the actual name of your custom post type
            'posts_per_page' => -1 // Adjust the number of posts per page as needed
        );

        // The Query
        $the_query = new WP_Query($args);

        // The Loop
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) : $the_query->the_post();
        ?>

                let inputToTakeFrom = <?php echo get_field("equation")['input_to_take_from']; ?>.value
                let operator = "<?php echo get_field("equation")['operator']; ?>"
                let withType = "<?php echo get_field("equation")['input_type']; ?>"

                let currentField = document.getElementById("<?php echo get_field("label"); ?>")

                console.log(inputToTakeFrom, operator, withType, currentField)
                if (withType === "number") {
                    let equation = inputToTakeFrom + operator + <?php echo get_field("equation")['number_to_operate_with']; ?>;
                    currentField.innerText = eval(equation);
                } else if (withType === "input") {
                    let inputToOperateWith = <?php echo get_field("equation")['input_to_operate_with']; ?>.value
                    let equation = inputToTakeFrom + operator + inputToOperateWith;
                    currentField.innerText = eval(equation)
                }
        <?php
            endwhile;
        }
        ?>
    }
</script>


<?php get_footer(); ?>