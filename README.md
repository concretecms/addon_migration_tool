# Installation

## Download the Correct Package

There are several versions of the Migration Tool designed to work with
various historical and current versions of Concrete CMS. Navigate to
the appropriate GitHub repository page and download the latests release of the master branch:

| Concrete CMS (concrete5) Version | Compatible Migration Tool                                                                   | Branch | Package Directory                                                                                                |
|----------------------------------|---------------------------------------------------------------------------------------------|--------|------------------------------------------------------------------------------------------------------------------|
| <=5.6.x (legacy)                 | [Addon Migration Tool (Legacy)](https://github.com/concretecms/addon_migration_tool_legacy) | master | [migration_tool](https://github.com/concretecms/addon_migration_tool_legacy/tree/master/packages/migration_tool) |
| 5.7x through 8.x                 | [Addon Migration Tool](https://github.com/concretecms/addon_migration_tool)                 | master | [migration_tool](https://github.com/concretecms/addon_migration_tool/tree/master/packages/migration_tool)        |
| 9.x+                             | [Migration Tool](https://github.com/concretecms/migration_tool)                             | master | [migration_tool](https://github.com/concretecms/migration_tool)                                                  |

## Install the Package on Your Concrete CMS

1. **Upload the package:**
   - Extract the downloaded ZIP file.
   - Upload or copy the `migration_tool` directory to your Concrete
     installations under `packages/` (located in the installation
     root).

# General Process Note

Exporting and importing content is not always a straightforward
process. Differences in the source and destination sites may require
new attribute mappings or other compromises. The hurdles and solutions
are not always obvious from the outset, so unless the two sites are
exact copies, plan on this being an iterative process. 

To help simplify this process, it may be useful to group exported data
into smaller batches of content either by type or by size. The
importation of these smaller batches can be verified for accuracy and
completeness and, if issues are found, can be corrected through
different mappings.

As part of this process, the destination site might accumulate
imported content which is not correct. A backup should be made of the
destination site before importing any content or, if the site is a
fresh installation, be prepared to drop the database and start
over. To simplify the process, content mapping settings can be saved
and revised until all content is imported correctly. This makes the
process repeatable and facilitates a final import after this
trial-and-error process.



# Exporting Content

From the source site, export the content using the following steps.

## Access the Migration Tool

- After installation, access the Migration Tool by navigating to
  **Dashboard** > **Migration Tool**.

## Create a New Export Batch

1. **Create Batch:**
   - Click on **Create New Batch**.
   - Name your batch for easy identification. Content is often
     exported in batches rather than all at once especially when there
     are large differences beteen the source and destination
     sites. For example, you might export users and associated
     information as one batch first, and then later export the pages
     they authored as another batch.

2. **Select Content to Export:**
   - Choose the content types you wish to export (e.g., pages, files, users).
   - Configure the specifics for each content type, such as which
     pages or which user data to include.

## Run the Export

- Once you’ve configured your batch, click **Export** to generate a
  XML file containing your selected content.
- Download this file to your local machine. It will be used to import
  content to the destination site.

# Importing Content

## Upload the Export File

- Navigate to **Dashboard** > **Migration Tool** on the destination site.
- Click on **Import Content**.

## Start the Import Process

1. **Upload the XML File:**
   - Use the file upload interface to select and upload the XML file
     you exported from the source site.

2. **Import Content:**
   - After the file is uploaded, the tool will automatically parse the XML.
   - Review the content and configurations to be imported. Map the
     content where needed. This is where breaking the exported content
     into batches as this process can be labor intensive. 
     - Once all content is mapped, consider saving the mapping
       settings. This can help save time if the import process does
       not work as expected. 
   - Click **Perform Import** to begin the import process.

## Verify the Imported Content

- After the import process completes, verify that all content has been
  successfully imported and is functioning as expected. You may have
  to try importing the content with different settings or mappings and
  check the results for completeness.
- Check for any discrepancies or issues and address them as
  necessary. If you have saved the content mappings, this
  trial-and-error process will be much easier.
