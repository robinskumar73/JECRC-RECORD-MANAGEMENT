<!--For displaying info and results-->
<div id="admin-department" class="hide">
    <p id="dept-info-box" class="text-danger col-sm-12 hide" style="text-align:center"></p>
    <div id="DepartmentCreate" class="col-sm-12">
        <button id="Dept-Cancel" type="button" class="close hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h3 id="dept-screen" class="col-sm-12 infoScreenHeader hide" style="margin-top:2px;"></h3>
        <input type="text" id="Department" class="form-control typeahead jecrc-dept-entry" placeholder="Department Name">
        <button type="button" id="create-dept" class="btn btn-primary jecrc-create-btn">Create</button>
        
    
    </div>
                        
    <div id="AddSemester" class="col-sm-12 AddSemester hide">
        <h4 class="blue-text semAddHeading">Add Semester</h4>
        <div id="radio-btn" class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary ">
                <input class="radio" type="radio" name="options" id="1" value="1"> I
            </label>
            <label class="btn btn-primary">
                <input class="radio" type="radio" name="options" value="2" > II
            </label>
            <label class="btn btn-primary">
                <input class="radio" type="radio" name="options" value="3"> III
            </label>
            <label class="btn btn-primary">
                <input class="radio" type="radio" name="options" value="4"> IV
            </label>
            <label class="btn btn-primary">
                <input class="radio" type="radio" name="options" value="5"> V
            </label>
            <label class="btn btn-primary">
                <input class="radio" type="radio" name="options" value="6"> VI
            </label>
             <label class="btn btn-primary">
                <input class="radio" type="radio" name="options" value="7"> VII
            </label>
             <label class="btn btn-primary">
                <input class="radio" type="radio" name="options" value="8"> VIII
            </label>
        </div>
    </div><!--DIV END FOR END SEMESTER-->
    
    
    
    <div id="AddSection" class="col-sm-12 AddSemester hide">
        <h4 class="blue-text semAddHeading">Add Section</h4>
        <div id="section-btn" class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary ">
                <input type="radio" name="options" id_="1" value="A" > A
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="options" value="B"  id_="2"> B
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="options" value="C" id_="3"> C
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="options" value="D" id_="4"> D
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="options" value="E" id_="5"> E
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="options" value="F" id_="6"> F
            </label>
             <label class="btn btn-primary">
                <input type="radio" name="options" value="G" id_="7"> G
            </label>
             <label class="btn btn-primary">
                <input type="radio" name="options" value="H" id_="8"> H
            </label>
             <label class="btn btn-primary">
                <input type="radio" name="options" value="I" id_="9"> I
            </label>
            
        </div>
    </div><!--DIV END FOR END SECTION-->
    
    
    
    
    <div id="AddBatches" class="col-sm-12 AddBatches hide">
        <h4 class="blue-text semAddHeading" >Select Batches</h4>
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary dept-check"  data-wat='1'>
                1
            </label>
            <label class="btn btn-primary dept-check"  data-wat='2'>
                 2
            </label>
            <label class="btn btn-primary dept-check" data-wat='3'>
                3
            </label>
            <label class="btn btn-primary dept-check" data-wat='4'>
                4
            </label>
            <label class="btn btn-primary dept-check" data-wat='5'>
                5
            </label>
            <label class="btn btn-primary dept-check" data-wat='6'> 
                6
            </label>
             <label class="btn btn-primary dept-check" data-wat='7'>
                7
            </label>
            <label class="btn btn-primary dept-check" data-wat='8'>
                8
            </label>
            <label class="btn btn-primary dept-check" data-wat='9'>
                9
            </label>
        </div>
       
    </div><!--DIV END FOR END ADD BATCHES-->
    <div id="publish-batch" class="col-sm-12 hide">
      <button type="button" class="btn btn-primary jecrc-create-btn  addSemBtn">Publish</button>
    </div>
    
    <!--DIV FOR DISPLAYING THE SELECTED SEMESTERS-->
    <div id="infoScreen" class="col-sm-12 hide" style="margin-top:20px">
        <div class="InfoScreen">
            <h2 class="infoScreenHeader"></h2>
            <p class="infoScreenSubHeader hide">
                <!--<span class="h4">3CSA</span>-->
            </p>
        </div><!--DIV ENDS FOR INFO SCREEN-->
    </div> <!--DIV ENDS FOR DISPLAYING THE SELECTED SEMESTERS-->
    
    
    
     <!--DIV FOR ADDING FACULTY-->
    <div class="col-sm-12"><!--INFO for adding faculty-->
        <div id="FacultyList" class="col-sm-12 AddFaculty" >
            <h4 class="blue-text semAddHeading" style="margin-bottom:18px;" > Faculty List </h4>
            <ul class="faculty-list">
                <li class="faculty-list-items" >
                     <h4 style="margin-bottom:0px;">Ravi Gupta</h4>
                     <span class="faculty-list-icons glyphicon glyphicon-pencil"></span>
                     <span class="faculty-list-icons glyphicon glyphicon-trash"></span>
                     <span  class="faculty-list-icons  glyphicon glyphicon-cog"></span>
                </li>
               <li class="faculty-list-items" >
                     <h4 style="margin-bottom:0px;">Robins Gupta</h4>
                     <input type="text" id="Department" value="Robins Gupta" class="form-control typeahead jecrc-dept-entry" placeholder="Edit faculty name">
                     <span class="faculty-list-icons glyphicon glyphicon-pencil"></span>
                     <span class="faculty-list-icons glyphicon glyphicon-trash"></span>
                     <span class="faculty-list-icons glyphicon glyphicon-cog"></span>
                </li>
               <li class="faculty-list-items" >
                     <h4  style="margin-bottom:0px;" >Suresh Gupta</h4>
                     <span class="faculty-list-icons glyphicon glyphicon-pencil"></span>
                     <span class="faculty-list-icons glyphicon glyphicon-trash"></span>
                     <span class="faculty-list-icons glyphicon glyphicon-cog"></span>
                </li>
             
            </ul>
        </div><!--DIV ENDS FOR ADDING FACULTY-->
    </div>
</div><!--DIV ENDS FOR ADMIN-DEPARTMENT-->