
// Function to calculate the total sales
function calculateTotalSales(data) {
    let totalSales = 0;
    for (let i = 0; i < data.length; i++) {
        totalSales += parseInt(data[i]);
    }
    return totalSales;
}

function drawBarChart(parentElement, salesData, X_CLUMEN, Y_CLUMEN, GRAP_TYPE) {
    let xLabels_ = [];
    let data = [];
    console.log(salesData.length + '<< iuii.length');
    console.log(salesData);
  
    // Check if child elements already exist in the parent
    const canvasparent = "-canvas";
    const canvas_ = "canvas-chart";
   
    const elementsToCheckAndCreate = [
    { selector: '.chart-type-line_label', tag: 'label', textContent: 'Line Chart', type: '' },
    { selector: '.chart-type-line', tag: 'input', textContent: 'line', type: 'radio' },
    { selector: '.chart-type-bar_lable', tag: 'label', textContent: 'Bar Chart', type: '' },
    { selector: '.chart-type-bar', tag: 'input', textContent: 'bar', type: 'radio' },
    { selector: '.-canvas', tag: 'div', textContent: formattedDate, type: 'canvas' }
    ];

    // Check and create missing elements within element B
    elementsToCheckAndCreate.forEach((elementInfo) => {
    const existingElement = parentElement.querySelector(elementInfo.selector);
    if (!existingElement) {
        // Get the current date
        // Format the date as YYYY-MM-DD (required by the date input element)
        const newElement = document.createElement(elementInfo.tag);
        newElement.className = elementInfo.selector.substr(1); // Remove the dot from the selector to set the class name
        parentElement.appendChild(newElement);

        if(elementInfo.tag == 'label'){
            // Create the label for the Line Chart
            // Create the label for the Bar Chart
            // Create the label for the Start Date
            newElement.textContent = elementInfo.textContent;
        }
        
        else if(elementInfo.type == 'radio'){
            // Create the input element for the Bar Chart
            // Create the input element for the Line Chart

            newElement.setAttribute('type', 'radio');
            newElement.setAttribute('name', 'chart-type');
            newElement.setAttribute('id', elementInfo.selector.substr(1));
            newElement.setAttribute('value', elementInfo.textContent);
            if(elementInfo.textContent == 'line') newElement.setAttribute('checked', 'checked');
        }

        else if (elementInfo.type == 'canvas') {
        
            // Create the canvas parent element
            newElement.setAttribute('id', '-canvas');
            newElement.style.width = '100%'; /* Set the width to 100% of the parent container */
        
            // Create the canvas element
            const canvas = document.createElement('canvas');
            canvas.setAttribute('id', 'canvas-chart');
        
            // Append the canvas element to the canvas parent
            newElement.appendChild(canvas);
        }
    }
    });
    



    // Function to handle chart type change
    function handleChartTypeChange() {
        drawBarChart(parentElement, salesData, X_CLUMEN, Y_CLUMEN, GRAP_TYPE);
    }


    // Event listeners
    document.querySelectorAll('input[name="chart-type"]').forEach((input) => {
        input.addEventListener('change', handleChartTypeChange);
    });

    

    if (!parentElement.querySelector('#sales-report')) {
        // Create the report container
        const salesReport = document.createElement('div');
        salesReport.setAttribute('class', 'report');
        salesReport.setAttribute('id', 'sales-report');
    
        // Create the Sales Report heading
        const reportHeading = document.createElement('h2');
        reportHeading.textContent = 'Sales Report';
    
        // Create the paragraph for Total Sales
        const reportTotalSales = document.createElement('p');
        reportTotalSales.textContent = 'Total Sales: ';
        const spanReportTotalSales = document.createElement('h3');
        spanReportTotalSales.setAttribute('id', 'report-total-sales');
        reportTotalSales.appendChild(spanReportTotalSales);
    
        // Append all elements to the parentElement
        parentElement.appendChild(salesReport);
        salesReport.appendChild(reportHeading);
        salesReport.appendChild(reportTotalSales);
    }
    
    const canvasparentElement = document.getElementById(canvasparent);

    const canvasWidth = 700; // Set the desired width for the canvas
    const canvasHeight = 300; // Set the desired height for the canvas

    // Remove existing canvas if it exists
    const existingCanvas = document.getElementById(canvas_);
    if (existingCanvas) {
        existingCanvas.remove();
    }

    // Create the sales chart canvas
    const canvas = document.createElement('canvas');
    canvas.id = canvas_;
    canvas.width = canvasWidth;
    canvas.height = canvasHeight;
    canvasparentElement.appendChild(canvas);


    const chartType = parentElement.querySelector('input[name="chart-type"]:checked').value;
    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;
    const x = 50;
    const y = 20;

    data = [];
    for (let i = 0; i < salesData.length; i++) {
        xLabels_.push(salesData[i][X_CLUMEN]);
        data.push(salesData[i][Y_CLUMEN]);
    }

    // Calculate the maximum value in the data
    const maxDataValue = Math.max(...data, 1); // Use Math.max with 1 to ensure a minimum value of 1

    // Calculate the scale factor for the chart
    const scaleFactor = height / maxDataValue;

    // Calculate the width of each bar
    // Calculate the width of each bar
    const barWidth = width / Math.max(data.length, 1); // Use Math.max with 1 to ensure a minimum bar width of 1

    // Clear the canvas
    ctx.clearRect(x, y, width, height);

    // Draw the square grid lines
    ctx.strokeStyle = 'lightgray';

    // Vertical grid lines
    for (let i = 0; i < data.length; i++) {
        const xx = x + i * barWidth;
        ctx.beginPath();
        ctx.moveTo(xx, y);
        ctx.lineTo(xx, height - y);
        ctx.stroke();
    }

    // Horizontal grid lines
    const yAxisLabelsCount = 10;
    const yStep = maxDataValue / yAxisLabelsCount;
    for (let i = 0; i <= yAxisLabelsCount; i++) {
        const yy = height - i * (height / yAxisLabelsCount) - y;
        ctx.beginPath();
        ctx.moveTo(x, yy);
        ctx.lineTo(width, yy);
        ctx.stroke();
    }


    // Draw the chart
    ctx.fillStyle = 'blue';

    if (chartType === 'bar') {
        for (let i = 0; i < data.length; i++) {
        const xx = x + i * barWidth;
        const barHeight = data[i] * scaleFactor;
        const yy = height - barHeight - y;

        ctx.fillRect(xx, yy, barWidth, barHeight);
        }
    } 
    else if (chartType === 'LINE') {
        ctx.beginPath();
        ctx.moveTo(x, height - data[0] * scaleFactor);

        for (let i = 1; i < data.length; i++) {
        const xx = x + i * barWidth;
        const yy = height - data[i] * scaleFactor;
        ctx.lineTo(xx, yy);
        }

        ctx.strokeStyle = 'blue';
        ctx.lineWidth = 2;
        ctx.stroke();
    }


    // Draw the x and y axis labels
    ctx.fillStyle = 'black';
    ctx.font = '12px Arial';

    const xStep = width / data.length;

    for(let i = 0; i < data.length; i++) {
        const x = i * xStep + barWidth / 2 + 10;
        const y = height;
        ctx.fillText(xLabels_[i], x, y);
    }

    // Y-axis labels (sales count)
    for (let i = 0; i <= yAxisLabelsCount; i++) {
        const label = Math.round(yStep * i);
        const x = 10;
        const y = height - i * (height / yAxisLabelsCount);
        ctx.fillText(label, x, y);
    }

    // Update the sales report
    const reportTotalSales = document.getElementById('report-total-sales');
    reportTotalSales.textContent = calculateTotalSales(data);
}

