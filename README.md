# FirmChecker

## Design patterns that have been used:
When designing and implementing system, I will at minimum adhere to TDD, SOLID and DRY.

### MVC
Used to separate applications concerns. i.e Controllers / Model / Views. i.e Laravel, Zend etc.

### Facade

Using a facade helps to remove complex subsystems from the client caller.
Used here to the hide the complex subsystem of retrieving data for dashboard from cache or database, saving to cache and any other related funtionalities.

### Repository

Mediates between the domain and data mapping layers using a collection-like interface for accessing domain objects.

### Database Performance (sluggish data-reads from the MySQL database)

Configurations
- Ensure that enough RAM is set aside for InnoDB buffer pool via mysql configuration (innodb_buffer_pool_size). Tweaking and performing tests will need to be made to see if improvements can be achieved.

- Look at enabling slow query logs and set a threshold and review the queries that are taking longer than this threshold. Review each query and determine if the query can be improve i.e joining on a large table, ensure only columns required are being selected, make use of composite indexes that aligns with existing queries (Also look to remove uncessary indexes).

Caching
- Look to use some form of in-memory caching mechanism such as memcache/Redis for repeated queries for better performance. Caching data and invalidating them on write will provide increase performance. i.e A user visits the site, we query the database to retrieve the data, we then save this data in-memory. The next time the user visits the site, because a cache exist, the user automatically recieves the cache data which bypasses the need to query the database which is slow (generate once, read many).

- Look to use some form of pre-generated (HTML) caching to further improve performance. Break down the website into modules (i.e navigation, footer, most popular etc) and cache these HTML outputs further reducing the number of connections and queries to the database, thus improving performance of the system as a whole.

- Memory is limited, so keep this for important/frequent used data and look to use file cache (keep in mind I/O is slower) for others. i.e Above HTML cache files for modules.

Scaling
- Consider Vertical scaling with increases in CPU/RAM/SSD storage i.e bigger capacity server. Vertical scale is simple as it reduces risks in managing multiple server. However, Vertical scaling may help in the short term (which may be fine) but there will be a point in time when it has reached its limit with diminishing return and may not be the right approach.

- Consider Horizontal scaling with multi instances for improve performance. Scaling out Read is easy with horizontal scale with replication. If the system is bottle-necked by Read performance, then this can be applied. If Writes performance is the issue, we can scale out horizontal Writes with sharding. Sharding means breaking up the database into separate parititions that lives on different instances. However, the underlying system will need to be modified to support query routing, which brings on another level of complexities i.e application needs to understand which instance to update as different partitions are now sitting on different instances.

Queries

- Apply temporary table if possible to combine data sets together into one table. Once a temporary table is created, we can then query the table multiple times for different purposes.

- Inspect queries by running EXPLAIN too see the amount of data that it is traversing and what indexes are currently being used etc to see if there are improvements that can be made.

- Ensure queries are retrieving only required columns.

- Breaking down a single table down (with duplicating data) into smaller tables may help with performance. Also look to break down single complex query into mutliple queries and have PHP post process to see if there are improvements.

- Look to store any "counting" columns within respective table. For example, if we need to keep track of user's number of reviews, number of events etc, create columns in users table and update the count.

- In terms of the listing page, make use of pagination to ensure subset of data is accessed only.


### Data security and external use

A) For security purposes, always create separate users with different READ/WRITE permissions and access levels to tables and data.

B) Make use of Views to ensure only required data are visible to the external users. i.e providing subsets of data, a subset of columns (i.e hiding personal and financial information etc)

You can make use of Views that exposes statistical data to the user and not the underlying data.

C) Consider RBAC (Role-based access control) to provide a form of security layer based on permissions to restrict certain access to system components and data. This will provide a more manageable way of providing access to users of the system. When the number of new users increases, the use of RBAC significantly reduces the complexities around managing access. Once a Role is given to a user, they automatically are given the permissions to access the system and no extra requirements or management is needed. When a new permission is created and added to a Role, all existing users will gain this permission. Thus, RBAC roles provide both effective and efficients means of controlling access to various components and data of a system.

Example roles:
- Admin
- Organisation
- User

Example access for view components:
- view_dashboard_index
- view_users_index
- view_profile_activity_block

Example access for action:
- action_add_user
- action_edit_user
- action_delete_user

Example access for data:
- data_events_all
- data_events_organisation
- data_events_user

D) Ensure that passwords make use of strong hashing algorithyms (i.e bcrypt) and sensitive information such as payment details are encrypted at all times.

E) Consider creating RESTs API's as an integration layer to the database (rather than directly to database), providing data to external systems.

