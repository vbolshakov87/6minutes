<?php

use Zizaco\Entrust\EntrustRole;

/**
 * Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('auth.model[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust::permission[] $perms
 * @property mixed $permissions
 */
class Role extends EntrustRole
{
	const ROLE_ADMIN = 'admin';
	const ROLE_MANAGER = 'manager';
}