Add your contributions here:


# Permission Gate #
We made use of the Gate facade to manage permissions and roles.
The models involved are:
Permission, Role, PermissionRole, RoleUser

In routes.php, we use a Middleware defined as acl (access control list). It takes a permission name as a parameter.
In laravel/database/seeds/PermissionsTableSeeder.php there is an array that defines which roles have which permissions.