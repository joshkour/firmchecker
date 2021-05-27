# FirmChecker

## Design patterns that have been used:

### MVC

Used to separate applications concerns. i.e Controllers / Model / Views.

### Facade

Using a facade helps to remove complex subsystems from the client caller.
Used here to the hide the complex subsystem of retrieving data for dashboard from cache or database, saving to cache and any other related funtionalities.

### Repository

Mediates between the domain and data mapping layers using a collection-like interface for accessing domain objects.

## Database Performance (sluggish data-reads from the MySQL database)

-) Ensure that enough RAM is set aside for InnoDB buffer pool via mysql configuration.

-) Look to use some form of in-memory caching mechanism such as memcache/Redis for better performance. Redis supports partitioning across multiple instances, thus allowing horizontal scaling for performance (using memory of each instance for a partition).

-) Look to use some form of output (HTML) caching to further improve performance by bypassing database and/or in-memory cache altogether. Break down websites into modules (i.e navigation, footer, most popular etc) and cache these HTML outputs reducing the number of connections and queries to the database, thus improving performance of the system as a whole.

-) Use temporary table to combine data sets together into one table. Once a temporary table is created, we can then query the table multiple times for different purposes, thus improving performance.

-) Look at enabling slow query logs and set a threshold and review the queries that are taking longer than this threshold. Review each query and determine if the query can be improve i.e joining on a large table, ensure only columns required are being selected, make use of composite indexes that aligns with existing queries (Also look to remove uncessary indexes).

-) Inspect queries by running EXPLAIN too see the amount of data that it is traversing and what indexes are currently being used.

-) Breaking down a single table down (with duplicating data) into smaller tables may help with performance. Also look to break down single complex query into mutliple queries to see if there are improvements.

-) Look to store any "counting" columns within respective table. For example, if we need to keep track of user's number of reviews, number of events etc, create columns in users table and update the count.

-) In terms of the listing page, make use of pagination to ensure subset of data is queried at that time.


## Data security and external use

A) Make use of Views to ensure only required column and data are visible to the external user or application. This is much simpler than maintaining a separate database with its own tables.

B) Consider RBAC (Role-based access control) to provide a form of security based on permissions to restrict certain access to system components and data. This will provide a more manageable way of providing access to users of the system.

The user of the system will be assigned a Role, where permissions are attached to a given role. Depending on the role a user has, they will restricted to certain areas of the system and data.

Example roles:
- Admin
- Organisation
- User


Example access for view components:
- view_profile_activity
- view_dashboard
- view_user_listings

Example access for action:
- action_add_user
- action_edit_user
- action_delete_user

Example access for data:
- data_users_all
- data_users_organisation

