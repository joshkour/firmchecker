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

A) Look at enabling slow query logs and set a threshold and review the queries that are taking longer than this threshold. Review each query and determine if the query can be improve i.e ensure only columns required are being selected, look out for LIKE statements, make use of composite indexes are present that aligns with existing queries (Also look to remove uncessary indexes).

B) Look at using temporary tables as they are stored in memory, which are faster than disk based tables. If there are complex queries, use temporary tables
to break it up into simpler queries as oppose to joins.

C) Breaking down a single table down into smaller tables. If the number of rows in one single table with proper indexes is not performing well, making multiple mysql queries with reduced rows in each may perform better.

D) If there are too many joins due to normalisations, ensure query does not join to a large table.

E) Look to use some form of data caching mechanism such as memcache/Redis for better performance. Determine which data is not required to be displayed as "live" data and cache data based on N minutes.

F) Look to use some form of output (HTML) caching to further improve performance by bypassing database and/or data cache altogether. Break down websites into modules (i.e navigation, footer, most popular etc) and cache these HTML outputs reducing the number of connections and queries to the database, thus improving performance of the system as a whole.

G) Look to store any aggregate counting columns against its own table. For example, if we needed to keep track of user's number of reviews, number of events etc, keep these together in the users table and update the count (Do not need a normalised table and adding a new row).

H) In terms of the listing page, make sure pagination of listing items are used as oppose to showing complete list.


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

