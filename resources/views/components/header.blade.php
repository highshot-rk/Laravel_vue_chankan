
<header id="header" v-bind:class="{ isOpen : isSearchActive}">
  <div class="tab">
    <form id="search" @if ($isCharge) action="{{ route('charge.search') }}" @else action="{{ route('search') }}" @endif method="GET">
      <div class="searchTable">
        <div class="searchButton">
          <input class="clickonce" type="submit" name="" value="案件を検索する">
        </div>
      </div>
      <div class="allWrapper">
        <div class="header__inner flex__wrap f__center">
          <div class="header__left">
            <?php
              $url = $_SERVER['REQUEST_URI'];
              if(strstr($url,'calendar?year')==false):
            ?>
            <div class="arrow" onclick="javascript:window.history.back(-1);return false;">
              <img src="{{ asset('assets/img/icon_arrow_left_black.png') }}">
            </div>
            <?php endif; ?>
          </div>
          <div class="header__center">
            <div class="logo">
              <img src="{{ asset('assets/img/logo.png') }}">
            </div>
          </div>
          <div class="header__right">
            <div class="search f__center commonShadow">
              <div class="search__inner flex__wrap">
                <div class="search__text"><input form="search" type="search" name="keyword" v-model="textbox" placeholder="キーワードを入力"></div>
                <div class="search__person">
                  <select name="charge_id" form="search">
                      <option value="">担当者名</option>
                      @auth('web')
                      @foreach ($charges as $charge)
                          <option value="{{ $charge->id }}">{{ $charge->name }}</option>
                      @endforeach
                      @endauth
                  </select>
                </div>
              </div>
              <span class="searchToggle" v-on:click="toggleSearch"><img src="{{ asset('assets/img/icon_header_search_black.png') }}"></span>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="pc">
    <div class="allWrapper">
      <div class="search__input flex__wrap f__end">
        <form @if ($isCharge) action="{{ route('charge.search') }}" @else action="{{ route('search') }}" @endif method="GET">
          <div class="search__input__inner flex__wrap f__end">
              <div class="box keyword"><input type="text" name="keyword" placeholder="ここにキーワードを入れる"></div>

              <div class="box charge selectBox">
                  <div class="input__box selectBox">
                      <select name="charge_id">
                          <option value="">担当者名</option>
                          @auth('web')
                          @foreach ($charges as $charge)
                              <option value="{{ $charge->id }}">{{ $charge->name }}</option>
                          @endforeach
                          @endauth
                      </select>
                  </div>
                  {{-- <input type="text" name="charge_id" placeholder="担当者名"> --}}
              </div>
              <div class="box submit bgCenterCover clickonce"><input type="submit" name=""></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</header><!-- /header -->
