<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/complaints.css" />
    <link rel="stylesheet" href="css/all.css" />
    <title>Zoe dataCollection</title>
</head>

<body>
    <main>
        <section id="first" class="active">
            <div class="bg">
                <img src="images/bbg6.jpg" alt="" />
                <div class="message">
                    <div class="flex">
                        <picture>
                            <img src="images/download.jpeg" alt="" />
                            <img src="zoe.jpg" alt="" />
                        </picture>
                        <h1 class="title"><span> ZOE </span> &nbsp; ONLINE &nbsp; <span class="span2">FORUM</span></h1>
                    </div>
                    <header>
                        ! Do you have unresolved problems with <span>happenings, activites,
                            persons,authorities</span>,etc in the church,then we will be happy to help you
                        resolve this problem so that we can live as sons and daughters of the lord
                        It is to be noted that this platform is built to recieve complains and suggestions only !</span>
                    </header>
                </div>
            </div>
        </section>
        <sections>
            <div class="wrapper">
                <h1>What to do ?.</h1>
                <div class="details">
                    <img src="../bg/complaint.jpg" alt="complaintSvg">
                    <div class="text">
                        <h1>*Complaints and suggestions are not subject to members only*</h1>
                        <ul>
                            <li>Have a topic to suggest / comment</li>
                            <li>Make the topic as brief as possible</li>
                            <li>Summarize your comment and specify which category it belongs to</li>
                            <li>Provide a means of contact in the case the administration wants more information</li>
                            <li>Rest assured you will remain anonymous</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="wrapper">
                <h1>The Comment Session</h1>
                <form id="form">
                    <div class="addPost">
                        <div class="error" style="margin-bottom:10px;">
                            <p id="error" style="font-size:bold;text-transform:capitalize;"></p>
                        </div>
                        <div class="field" style="margin-bottom:20px">
                            <label>Choose a complaint option</label>
                            <select name="category">
                                <option>Insult</option>
                                <option>Deceit</option>
                                <option>Fraud</option>
                                <option>Ill mannered</option>
                                <option>Others</option>
                            </select>
                        </div>
                        <div class="field" style="margin-bottom:20px">
                            <label>Name(Please provide actual name eg(Kweku doris, efo doko manunovefa. etc))</label>
                            <input type="text" name="name" placeholder="Enter your name" />
                        </div>
                        <div class="field" style="margin-bottom:20px">
                            <label>Provide a medium of contact.</label>
                            <input type="text" name="contact" placeholder="Enter phone number or email" />
                        </div>
                        <textarea id="iframe" name="textField" style="padding:5px">
                    Add details..
                    </textarea>
                        <div class="block">
                            <div class="flex" style="padding-bottom:20px">
                                <button class="btn-btn" id="submit" value="POST">Post</button>
                                <p class="ccc">Post yor answer by clicking the "Post"
                                </p>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </sections>
    </main>
</body>
<script src="js/complains.js"></script>
<script>




</script>

<!-- </html>
        <div class="bg absolute"><img src="../bg/complaint.jpg" alt="complaintSvg"></div>
        <div class="text block absolute">
            <h3><span> ZOE  </span>  &nbsp; ONLINE  &nbsp; <span class="span2">FORUM</span></h3>
            <p>!Do you have unresolved problems with <span>happenings, activites,
                persons,authorities,etc in the church,</span>then we will be happy to help you
                resolve this problem so that we can live as sons and daughters of the lord
                It is to be noted that this platform is built to recieve complains and suggestions
            </p>
        </div>
</div>
<form id="form">
<div class="addPost">
    <div class="error"><p id="error">All fields are required</p></div>
<textarea id="iframe" name="textField"></textarea>
<div class="field">
    <label>Name(Please provide actual name eg(Kweku doris, efo doko manunovefa. etc))</label>
<input type="text" name="text" placeholder="Enter your name" />
</div>
<div class="block">
  <div class="flex" style="margin-bottom:20px">
      <input type="submit" class="blue" id="submit" value="POST" />
      <p class="ccc">Post yor answer by clicking the "Post" 
        </p>
  </div>
</div>

</div>
</form>


    </div> 