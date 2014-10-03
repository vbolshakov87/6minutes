<?php

class RoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        $adminRole = new Role;
        $adminRole->name = Role::ROLE_ADMIN;
        $adminRole->save();

        $user = User::where('username','=','admin')->first();
        $user->attachRole( $adminRole );

	    $managePosts = new Permission;
	    $managePosts->name = 'manage_posts';
	    $managePosts->display_name = 'Manage Posts';
	    $managePosts->save();

	    $adminRole->perms()->sync(array($managePosts->id));
    }
}
