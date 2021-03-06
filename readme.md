## Minecraft Web API Benchmarking

Me, as the owner of McAPI.de, I made a statement that McAPI.de is one of the fastest APIs out in the ocean to prove that I developed a little PHP script.
The benchmark script is only testing the UUID to Name endpoint.

I tested the following services:

- http://mcapi.de
- http://mcapi.ca (currently not included, removed endpoint 5/1/2017 - https://screenshots.firefoxusercontent.com/images/5fe3d541-d687-4c5b-a716-e52e2e757376.png)
- http://minecraft-api.com 
- http://mc-api.net (currently not included, removed endpoint 28/5/2017 - https://screenshots.firefoxusercontent.com/images/21282260-8bdb-4051-81bf-436dbc1b68e0.png)
- http://api.razex.de (currently not included, not working 28/5/2017 - http://puu.sh/q1L6l/74170fdfd5.png)

# Hardware and Software
To run this benchmark I am using my own computer. It's running a Intel i7-5930k, 16GB DDR4 on Samsung 840EVO SSD. On the software site is a PHP5.6 back-end.
The script itself can be found in this repository, if you have any complains feel free to create a new PR.
The network is an async 25Mb connection in Germany provided by 1&1.  

# Run & Submit
You also can run this on your own setup. Just clone the project and run the `php index.php` from your console. Than copy the result into a text file
called `benchmark-d-m-yyyy-<your-username>.txt`. Create a new PR and done.

# Score
 - Lower score is better.
 - The expression for the calculation is (t * 1000) / b
    * t -> time in seconds
    * b -> total bytes
 - This calculation is fair because it takes also the amount of data provided by the API not only the execution time.  

# Disclaimer
- I am the founder and developer of the McAPI.de.
- All requests were made with the same script, software setup and hardware.
- All requests were executed twice, because the benchmark should simulate a best-case requests. The best case is that the identifier and the data related to it has been stored in some kind of cache that can be re-used now in the second request.
- This repository is just an information place. All results are without any judging.
