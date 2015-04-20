
        <aside class="bg-dark lter aside-md hidden-print" id="nav">          
          <section class="vbox">
            <header class="header bg-primary lter text-center clearfix">
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-dark btn-icon" title="New project"><i class="fa fa-plus"></i></button>
                <div class="btn-group hidden-nav-xs">
                  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                    Create New Project &nbsp;
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu text-left">
                    <li><a href="{{ route('create.index', 'capex') }}">CAPEX</a></li>
                    <li><a href="{{ route('create.index', 'opex') }}">OPEX</a></li>
                  </ul>
                </div>
              </div>
            </header>
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                
                
                <nav class="nav-primary hidden-xs">
                  <ul class="nav">
                    
                    <li class="{{ set_active('home'); }}">
                      <a href="{{ route('home') }}" class="{{ set_active('home.index') }}">
                        <i class="fa fa-dashboard icon">
                          <b class="bg-danger"></b>
                        </i>
                        <span>Home</span>
                      </a>
                    </li>
                   
                   <li class="{{ set_active('search'); }}">
                      <a href="{{ route('search') }}" class="{{ set_active('search.search') }}">
                        <i class="fa fa-search icon">
                          <b class="bg-primary"></b>
                        </i>
                        <span>Search Project</span>
                      </a>
                    </li>

                    <li class="{{ set_active('list') }}">
                      <a href="#list"  >
                        <i class="fa fa-question-circle icon">
                          <b class="bg-warning"></b>
                        </i>
                        <span class="pull-right">
                          <i class="fa fa-angle-down text"></i>
                          <i class="fa fa-angle-up text-active"></i>
                        </span>
                        <span>Project List</span>
                      </a>
                      <ul class="nav lt">
                        <li class="{{ set_active('list.consultant') }}">
                          <a href="{{ route('list.consultant') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>Consultant</span>
                          </a>
                        </li>
                        <li class="{{ set_active('list.contractor') }}">
                          <a href="{{ route('list.contractor') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>Contractor</span>
                          </a>
                        </li>
                        <li class="{{ set_active('list.supplier') }}">
                          <a href="{{ route('list.supplier') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>Supplier</span>
                          </a>
                        </li>
                      </ul>
                    </li>



                    <li class="{{ set_active('config') }}">
                      <a href="#questions"  >
                        <i class="fa fa-magic icon">
                          <b class="bg-success"></b>
                        </i>
                        <span class="pull-right">
                          <i class="fa fa-angle-down text"></i>
                          <i class="fa fa-angle-up text-active"></i>
                        </span>
                        <span>Settings</span>
                      </a>
                      <ul class="nav lt">
                        <li class="{{ set_active('config.consultant') }}">
                          <a href="{{ route('config.consultant') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>Consultant Question</span>
                          </a>
                        </li>
                        <li class="{{ set_active('config.contractor') }}">
                          <a href="{{ route('config.contractor') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>Contractor Question</span>
                          </a>
                        </li>
                        <li class="{{ set_active('config.supplier') }}">
                          <a href="{{ route('config.supplier') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>Supplier Question</span>
                          </a>
                        </li>
                        {{-- <li class="{{ set_active('config.buyer') }}">
                          <a href="{{ route('config.buyer') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>Buyers</span>
                          </a>
                        </li> --}}
                        <li class="{{ set_active('config.vendor') }}">
                          <a href="{{ route('config.vendor') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>Vendors</span>
                          </a>
                        </li>
                      </ul>
                    </li>


                    <li class="{{ set_active('user'); }}">
                      <a href="#users">
                        <i class="fa fa-user icon">
                          <b class="bg-info"></b>
                        </i>
                        <span class="pull-right">
                          <i class="fa fa-angle-down text"></i>
                          <i class="fa fa-angle-up text-active"></i>
                        </span>
                        <span>User &amp; Group</span>
                      </a>
                      <ul class="nav lt">
                        <li class="{{ set_active('user.user') }}">
                          <a href="{{ route('user.list') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>User</span>
                          </a>
                        </li>
                        <li class="{{ set_active('user.group') }}">
                          <a href="{{ route('group.assign') }}">
                            <i class="fa fa-angle-right"></i>
                            <span>Group</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    
                  </ul>
                </nav>
                
              </div>
            </section>
            
            <footer class="footer lt hidden-xs b-t b-dark">
              <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
                <i class="fa fa-angle-left text"></i>
                <i class="fa fa-angle-right text-active"></i>
              </a>
            </footer>
          </section>
        </aside>