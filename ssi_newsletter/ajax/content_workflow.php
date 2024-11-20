<?php
echo "\n<link rel='stylesheet' href='js/mermaid/mermaid.css'>";
//echo "<link rel='stylesheet' href='js/mermaid/mermaid.forest.css'>";

$test1 = "
graph TB
A(Meister)
B(Berti)
C(Michi)
D(Summe)
F(Mehr)
G(einen Tag warten)
H(Ende)
I(hier geht es weiter)
J(und mehr)
A -- Ja --> B
A -- Nein --> C
B --> D
C --> D
D --> F
F --> G 
G -.-> A
G --> H
G -.-> D
G -.-> I
I --> J
J --> A		
classDef green fill:#9f6,stroke:#333,stroke-width:1px;
classDef orange fill:#f96,stroke:#333,stroke-width:1px;
class A green
class G orange";

echo "<h2>Workflow</h2>";
echo "<div class='mermaid'>$test1</div>";
echo "<script type='text/javascript' src='js/mermaid/mermaid.js'></script>";
echo "\n<script>
        var config = {
            startOnLoad:true,
            flowchart:{
                    useMaxWidth:false,
                    htmlLabels:true
            }
        };
        mermaid.initialize(config);
    </script>";

exit;


?>

<div class='mermaid' >
graph TB
	
AA("start<br><i class='icon star'></i>") --> BB((+)) 		
		
</div>";


<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel='stylesheet' href='../js/mermaid/mermaid.css'>
	<script type='text/javascript' src='../js/jquery.min.js'></script>
	<script type='text/javascript' src='../js/mermaid/mermaid.js'></script>
	<script>mermaid.initialize({startOnLoad:true});</script>
	</head>
<body>
<div class='mermaid' >
	
graph TB
A(Meister)
B(Berti)
C(Michi)
D(Summe)
F(Mehr)
G(einen Tag warten)
H(Ende)
I(hier geht es weiter)
J(und mehr)
A -- Ja --> B
A -- Nein --> C
B --> D
C --> D
D --> F
F --> G 
G -.-> A
G --> H
G -.-> D
G -.-> I
I --> J
J --> A		
classDef green fill:#9f6,stroke:#333,stroke-width:1px;
classDef orange fill:#f96,stroke:#333,stroke-width:1px;
class A green
class G orange
</div>
</body>
</html>
