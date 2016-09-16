@extends('admin.app')

@section('content')    

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>id</th>
            <th>firsname</th>
            <th>lastname</th>
            <th>email</th>
            <th>vk_id</th>
            <th>create_at</th>
            <th>update_at</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->firstname; ?></td>
            <td><?php echo $user->lastname; ?></td>
            <td><?php echo $user->email; ?></td>
            <td><?php echo $user->vk_id; ?></td>
            <td><?php echo $user->created_at; ?></td>
            <td><?php echo $user->updated_at; ?></td>
        </tr>        
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php echo $users->render(); ?>

@endsection	