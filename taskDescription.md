- API only application (API Platform v3)
- Use PostgreSQL database and Doctrine
- Entities can have only properties as described below -
- API resources can have only operations as described below -
- Three roles:
    - ROLE_USER (default)
    - ROLE_COMPANY_ADMIN (manages users in their company)
    - ROLE_SUPER_ADMIN (manages all users, should have an option to impersonate any user)
- Two entities:
    - User
      id (int, automatically assigned on creation, cannot be changed after setting up)
      name (required, string, max 100 characters, min 3 charaters, requires letters and space only, one uppercase letter required) -
      role (required, string, choice between ROLE_USER, ROLE_COMPANY_ADMIN, and ROLE_SUPER_ADMIN
      role USER cannot change it, role COMPANY ADMIN can only set USER role)
      company (relation to the Company entity, required for USER and COMPANY ADMIN roles, SUPER ADMIN cannot have company)
    - Company
      id (int, automatically assigned on creation)
      name (required, string, max 100 characters, min 5 charaters, must be unique in the database)
- These entities should be available as API resources with conditions:
    - User: - operations: - GET /users, GET /users/{id} - available for all roles,
    - USER and COMPANY ADMIN can see only users from their company, SUPER ADMIN can see all users
    - POST /users - available for SUPERADMIN and COMPANY ADMIN - DELETE /users/{id} - available for SUPERADMIN only
    - Company: - operations: - GET /companies, GET /companies/{id} - available for all roles
    - POST /companies - available for SUPERADMIN only

- All endpoints and logic should be tested - All validation constraints should be tested
-------------------------------------------------------------------------------------------------------
Despite the detailed instructions, candidates might have some questions for clarification:

Update Operations:

Question: Should PUT or PATCH operations be implemented for updating User or Company entities?
Suggestion: They can choose.
Authentication Method:

Question: What authentication mechanism should be used (e.g., JWT, OAuth2, session-based)?
Suggestion: They can choose.
Impersonation Details:

Question: How should the impersonate feature for ROLE_SUPER_ADMIN be implemented?
Suggestion: They can choose and decide.
Company Field Constraints:

Question: For SUPER_ADMIN users who cannot have a company, should the company field be null or should it be omitted entirely?
Suggestion: They can choose and decide.
Role Assignment Limitations:

Question: Can a COMPANY_ADMIN assign the ROLE_COMPANY_ADMIN to other users, or only ROLE_USER?
Suggestion: They can choose and decide.
Name Validation for User:

Question: Should special characters (e.g., hyphens, apostrophes) be allowed in the name field?
Suggestion: They can choose and decide.
Testing Frameworks:

Question: Is there a preferred testing framework or any specific testing tools that should be used?
Suggestion: They can choose and decide.
Error Handling and Responses:

Question: Are there any standards or formats to follow for error messages and API responses (e.g., JSON
specification)?
Suggestion: They can choose and decide.
Database Migrations:

Question: Should database migration files be included as part of the task?
Suggestion: They can choose and decide.
Unique Constraints on User Entity:

Question: Besides the id, are there any other unique constraints (e.g., on name or email if added later)?
Suggestion: They can choose and decide.