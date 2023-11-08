# Politanalytics - Data Management Application

## Preface

This application is designed to manage and expose data related to Members of the European Parliament (MEPs).

## Project Setup

### Initial Configuration

Clone the project and install the dependencies using the following command:

```bash
composer install
```

### Database Setup
The application uses SQLite for database management. To set up and migrate the database, execute:
```bash
php bin/console doctrine:migrations:migrate
```


### Running the Application
Start the Symfony server using the command:
```bash
symfony server:start
```

### Running the Application
Start the Symfony server using the command:
```bash
symfony server:start
```

### Importing MEP Data
To import MEP data, including contact information, use the following CLI command:
```bash
php bin/console app:import-members
```

This will fetch and store data from the official European Parliament source.

# API Endpoints
### Collection Endpoint
**Endpoint**: **/api/members**

**Method**: **GET**

**Description:** Retrieves a list of MEPs without their contact information.

### Single Item Endpoint
**Endpoint**: **/api/members/{id}**

**Method**: **GET**

**Description**: Returns a detailed MEP profile including contact information.
