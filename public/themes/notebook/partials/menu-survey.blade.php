
        <aside class="bg-light b-r lter aside-lg hidden-print nav-xs" id="nav">
          <section class="vbox">
            
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                
                
                <nav class="nav-primary hidden-xs">
                  <ul class="nav">
                    <li class="{{ set_active('survey.new') }}">
                      <a href="{{ route('survey') }}"  >
                        <i class="fa fa-star-o icon">
                          <b class="bg-danger"></b>
                        </i>
                        <span>New</span>
                      </a>
                    </li>


                    <li class="{{ set_active('survey.done') }}">
                      <a href="{{ route('survey.done') }}"  >
                        <i class="fa fa-thumbs-o-up icon">
                          <b class="bg-info"></b>
                        </i>
                        <span>Done</span>
                      </a>
                    </li>


                    
                  </ul>
                </nav>
                
              </div>
            </section>
            
            <footer class="footer lt hidden-xs b-t b-default">
              <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-default btn-icon">
                <i class="fa fa-angle-left text-active"></i>
                <i class="fa fa-angle-right text"></i>
              </a>
            </footer>
          </section>
        </aside>