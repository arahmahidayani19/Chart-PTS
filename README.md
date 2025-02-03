Structure
1. Form Page (UI):
* Users select a time period (e.g., today, this week, or a custom date range) and choose the machine they want to analyze.
* The input data is collected and sent asynchronously in JSON format to a simple API.
2. API:
* Receives and decodes the input JSON data.
* Calculates the date range based on the selected time period 
* Queries the database to retrieve machine downtime data that matches the selected time range and machine.
* Formats the query results into a JSON structure containing the time range and downtime per machine, then returns it to the client.
3. Chart Page:
* The JSON data returned by the API is received via URL parameters and decoded by JavaScript.
* a machine downtime chart is generated based on the data, and users can return to the form (UI) for new analysis.

Flow Summary:
Form Input (UI) → Send Data to API → API Processes & Returns Data → Data Visualization in Chart
