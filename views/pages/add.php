<?php
$errors = $errors ?? [];  
?>

<h1>add</h1>
<form method="POST" action="/add" class="form">
    <div class="field">
        <label type="text" for="title">Name</label>
        <label>
            <input type="text" name="title">
        </label>  
        <?php if(!empty($errors['title'])): ?>
        <small ><?= $errors['title'] ?></small>
        <?php endif; ?>      
    </div>

  <div class="field">
        <label type="text" for="platform">platform</label>
        <label>
            <input type="text" name="platform">
        </label> 
         <?php if(!empty($errors['platform'])): ?>
        <small ><?= $errors['title'] ?></small>
        <?php endif; ?>        
    </div>
      <div class="field">
        <label type="text" for="genre">genre</label>
        <label>
            <input type="text" name="genre">
        </label>  
         <?php if(!empty($errors['genre'])): ?>
        <small ><?= $errors['genre'] ?></small>
        <?php endif; ?>       
    </div>
      <div class="field">
        <label type="text" for="releaseYear">releaseYear</label>
        <label>
            <input type="number" name="releaseYear">
        </label> 
         <?php if(!empty($errors['releaseYear'])): ?>
        <small ><?= $errors['releaseYear'] ?></small>
        <?php endif; ?>        
    </div>
      <div class="field">
        <label type="text" for="rating">rating</label>
        <label>
            <input type="number" name="rating">
        </label> 
         <?php if(!empty($errors['rating'])): ?>
        <small ><?= $errors['rating'] ?></small>
        <?php endif; ?>        
    </div>
      <div class="field">
        <label type="text" for="description">description</label>
        <label>
            <input type="text" name="description">
        </label>    
         <?php if(!empty($errors['description'])): ?>
        <small ><?= $errors['description'] ?></small>
        <?php endif; ?>     
    </div>
    <div class="field">
        <label type="text" for="notes">notes</label>
        <label>
            <input type="number" name="notes">
        </label>
         <?php if(!empty($errors['notes'])): ?>
        <small ><?= $errors['notes'] ?></small>
        <?php endif; ?>         
    </div>
    <button class="btn" type="submit">Add</button>
    
</form>