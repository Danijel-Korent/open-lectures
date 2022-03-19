<?php require "../Components/header.html"; ?>

<form data-abide novalidate>
<div class="grid-x grid-margin-x">
    <div class="cell large-4 small-12">
      <label>Username
        <input type="text" aria-describedby="exampleHelpTextNothing">
      </label>
    </div>
</div>

<div class="grid-x grid-margin-x">
    <div class="cell large-4 small-12">
      <label>Password
        <input type="password" id="password" aria-describedby="exampleHelpTextPassword">
      </label>
    </div>
</div>

<div class="grid-x grid-margin-x">
    <fieldset class="cell large-2 medium-6 small-12">
      <button class="button" type="submit" value="Submit">Login</button><br>
    </fieldset>
</div>
</form>

<?php require "../Components/footer.html"; ?>
