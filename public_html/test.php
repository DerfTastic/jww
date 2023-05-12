<!DOCTYPE html>
<html>
<head>
<style>
a { display: block; }
</style>
</head>
<body>
   <h1>GeeksforGeeks</h1>
    <hr>
  
    <div id="list">
        <a class="index" data-index="4.1">1</a>
        <a class="index" data-index="4.5">5</a>
        <a class="index" data-index="4.2">2</a>
        <a class="index" data-index="4.3">3</a>
        <a class="index" data-index="4.4">4</a>
    </div>
      
    <!-- onclick event to sort data-->
    <button onclick="SortData('index')">
        Sort HTML elements by Data Attributes
    </button>
      
    <script>
        function comparator(a, b) {
            if (a.dataset.index < b.dataset.index)
                return -1;
            if (a.dataset.index > b.dataset.index)
                return 1;
            return 0;
        }
          
        // Function to sort Data
        function SortData(attr) {
            var indexes = document.querySelectorAll("[data-" + attr + "]");
            var indexesArray = Array.from(indexes);
            let sorted = indexesArray.sort(comparator);
            sorted.forEach(e =>
                document.querySelector("#list").appendChild(e));
        }
    </script> 
</body>
</html>
