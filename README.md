# Installation

## Download the Package

Navigate to the Migration Tool’s GitHub repository page at https://github.com/concretecms/addon_migration_tool and download the latest release.

## Install the Package on Your Concrete CMS

1. **Upload the package:**
   - Extract the downloaded ZIP file.
   - Upload the `addon_migration_tool` directory to your Concrete CMS installations under `packages/` (located in the installation root).

# Exporting Content

## Access the Migration Tool

- After installation, access the Migration Tool by navigating to **Dashboard** > **Migration Tool**.

## Create a New Export Batch

1. **Create Batch:**
   - Click on **Create New Batch**.
   - Name your batch for easy identification.

2. **Select Content to Export:**
   - Choose the content types you wish to export (e.g., pages, files, users).
   - Configure the specifics for each content type, such as which pages or which user data to include.

## Run the Export

- Once you’ve configured your batch, click **Export** to generate a XML file containing your selected content.
- Download this file to your local machine—it will be used to import content to the destination site.

# Importing Content

## Upload the Export File

- Navigate to **Dashboard** > **Migration Tool** on the destination site.
- Click on **Import Content**.

## Start the Import Process

1. **Upload the XML File:**
   - Use the file upload interface to select and upload the XML file you exported from the source site.

2. **Import Content:**
   - After the file is uploaded, the tool will automatically parse the XML.
   - Review the content and configurations to be imported.
   - Click **Perform Import** to begin the import process.

## Verify the Imported Content

- After the import process completes, verify that all content has been successfully imported and is functioning as expected.
- Check for any discrepancies or issues and address them as necessary.
