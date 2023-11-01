<script>
    function read_chart_htmtable(_parent) {
        var url = 'Template/Get/Get_doc.php'; // The PHP script that fetches items from the database

        console.log('by=date()');
        var datasent = 'by=date()';

        // Store the current scroll position
        previousScrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Make an AJAX request to your PHP API
        sendAjaxRequest(url, 'POST', datasent, function(responseText) {
            console.log(responseText + '<< found doc');
            var response = JSON.parse(responseText);
            doc = response.doc;
            console.log(doc);
            console.log(doc.length + '<< doc.length');

            // Sample data for the charts
            const salesData = [];

            // Process the response and add the items to the itemContainer
            for (var i = 0; i < doc.length; i++) {
                salesData.push({
                    text: doc[i].doc_barcode,
                    date: doc[i].doc_updated_date,
                    value: doc[i].price,
                    qty: doc[i].qty,
                    type: doc[i].user_id
                });
            }

            console.log(salesData.length + '<< ikkkk.length');
            console.log(salesData);

            // Example usage
            const datad = [10,20,30,40,50];
            const chartType = 'bar';
            const startDate = '2023-07-01';
            const endDate = '2023-07-05';

            drawBarChart(_parent, salesData);
        },
            function(errorStatus) {
                // Handle error
                console.log('Error: ' + errorStatus);
            });
    }
</script>